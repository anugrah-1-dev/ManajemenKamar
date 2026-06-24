<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramCamp;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File; // Gunakan File facade untuk operasi file
use Illuminate\Support\Facades\Storage;
use App\Models\Rooms;
use Illuminate\Support\Facades\DB;
use App\Models\PendaftaranProgramCamp;
use App\Models\Thumbnail;



class ProgramCampController extends Controller
{
    public function index(Request $request)
    {
        $query = ProgramCamp::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $programs = $query->latest()->paginate(10);
        $programs->appends($request->all());

        // Pastikan thumbnail jadi array
        foreach ($programs as $program) {
            if (!empty($program->thumbnail) && is_string($program->thumbnail)) {
                $program->thumbnail = json_decode($program->thumbnail, true);
            }
        }

        return view('admin.programs.camp.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.camp.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'thumbnail' => 'nullable|array|max:5',
            'thumbnail.*' => 'image|max:5048',

        ]);

        $data = $request->except(['_token', 'thumbnail']);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nama']);
        }

        $thumbnails = [];

        if ($request->hasFile('thumbnail')) {
            foreach ($request->file('thumbnail') as $file) {
                if ($file->isValid()) {
                    $filename = Str::slug($data['nama']) . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('upload/camp'), $filename);
                    $thumbnails[] = $filename;
                }
            }
        }



        // Simpan sebagai JSON jika banyak gambar
        $data['thumbnail'] = json_encode($thumbnails);

        ProgramCamp::create($data);

        return redirect()->route('admin.programs.camp.index')->with('alert', [
            'title' => 'Berhasil!',
            'text' => 'Program berhasil ditambahkan.',
            'icon' => 'success',
        ]);
    }



    public function edit($id)
    {
        $program = ProgramCamp::with('thumbnails')->findOrFail($id);

        // Ambil thumbnails yang terkait program ini
        $thumbnails = $program->thumbnails;
        return view('admin.programs.camp.edit', compact('program', 'thumbnails'));
    }

    public function update(Request $request, $id)
    {
        $program = ProgramCamp::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'thumbnail' => 'nullable|array|max:5',
            'thumbnail.*' => 'image|mimes:jpg,jpeg,png|max:5048',
        ]);

        $data = $request->except(['_token', '_method', 'thumbnail']);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['nama']);
        }

        // Update data program
        $program->update($data);

        // Simpan thumbnail baru
        if ($request->hasFile('thumbnail')) {
            foreach ($request->file('thumbnail') as $file) {
                if ($file->isValid()) {
                    $filename = Str::slug($request->nama) . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('upload/camp', $filename, 'public'); // simpan di storage/app/public

                    $program->thumbnails()->create([
                        'image' => 'storage/' . $path // simpan langsung dengan prefix storage/
                    ]);
                }
            }
        }

        return redirect()->route('admin.programs.camp.index')->with('alert', [
            'title' => 'Berhasil!',
            'text' => 'Program berhasil diperbarui.',
            'icon' => 'success',
        ]);
    }



    public function deleteThumbnail($id)
    {
        $thumb = Thumbnail::findOrFail($id);

        if (Storage::disk('public')->exists($thumb->image)) {
            Storage::disk('public')->delete($thumb->image);
        }

        $thumb->delete();

        return back()->with('alert', [
            'title' => 'Berhasil!',
            'text' => 'Thumbnail berhasil dihapus.',
            'icon' => 'success',
        ]);
    }

    public function destroy($id)
    {
        $program = ProgramCamp::findOrFail($id);

        // Hapus thumbnail dari folder jika ada
        if ($program->thumbnail && File::exists(public_path('upload/camp/' . $program->thumbnail))) {
            File::delete(public_path('upload/camp/' . $program->thumbnail));
        }

        $program->delete();

        return redirect()->back()->with('alert', [
            'title' => 'Berhasil!',
            'text' => 'Program berhasil dihapus.',
            'icon' => 'success',
        ]);
    }

    public function show($id)
    {
        $program = ProgramCamp::findOrFail($id);
        return view('admin.programs.camp.show', compact('program'));
    }


    public function syncAllStokFromRoomsAjax()
    {
        // Ambil total kapasitas per program_camp_id tanpa hitung penghuni
        $kapasitasData = DB::table('rooms')
            ->select('program_camp_id', DB::raw('SUM(kapasitas) as total_kapasitas'))
            ->groupBy('program_camp_id')
            ->get();

        // Update stok di tabel program_camp dengan total kapasitas
        foreach ($kapasitasData as $data) {
            ProgramCamp::where('id', $data->program_camp_id)->update([
                'stok' => $data->total_kapasitas
            ]);
        }

        // Ambil data stok terbaru untuk response
        $programs = ProgramCamp::select(['id', 'stok'])->get();

        // Return response JSON ke frontend
        return response()->json([
            'success' => true,
            'programs' => $programs
        ]);
    }


    public function syncStokWithPenghuni()
    {
        $data = DB::table('rooms')
            ->leftJoin('pendaftaran_program_camp', function ($join) {
                $join->on('rooms.id', '=', 'pendaftaran_program_camp.room_id');
                // jangan pakai whereNull('deleted_at') di sini
            })
            ->select(
                'rooms.program_camp_id',
                DB::raw('SUM(rooms.kapasitas) as total_kapasitas'),
                DB::raw('COUNT(pendaftaran_program_camp.id) as total_penghuni')
            )
            ->groupBy('rooms.program_camp_id')
            ->get();

        foreach ($data as $row) {
            $stok = max(0, $row->total_kapasitas - $row->total_penghuni);

            ProgramCamp::where('id', $row->program_camp_id)->update([
                'stok' => $stok
            ]);
        }

        return response()->json(['success' => true]);
    }


    /**
     * Menampilkan halaman daftar semua camp untuk publik.
     */
    public function dashboardStok(Request $request)
    {
        // Ambil semua nama_kamar unik dari rooms
        $namaKamarList = rooms::select('nama_kamar')
            ->distinct()
            ->orderBy('nama_kamar')
            ->pluck('nama_kamar');

        // Query rooms
        $query = rooms::with('programCamp');

        if ($request->filled('nama_kamar')) {
            $query->where('nama_kamar', $request->nama_kamar);
        }

        $stokData = $query->get()->map(function ($room) {
            return [
                'nama'       => $room->nama,
                'stok'       => $room->kapasitas - $room->penghuni,
                'nama_kamar' => $room->nama_kamar,
                'program'    => optional($room->programCamp)->nama,
            ];
        });

        return view('admin.dashboard.stok', [
            'categories' => $namaKamarList,
            'stokData'   => $stokData,
        ]);
    }
}
