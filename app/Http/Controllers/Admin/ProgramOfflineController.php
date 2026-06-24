<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramOffline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgramOfflineController extends Controller
{
    public function index()
    {
        $programs = ProgramOffline::latest()->paginate(10);
        return view('admin.programs.offline.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.offline.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'             => 'required|string|max:255',
            'slug'             => 'required|string|max:255|unique:program_offline,slug',
            'lama_program'     => 'required|string|max:255',
            'kategori'         => 'required|string|max:100',
            'harga'            => 'required|numeric|min:0',
            'features_program' => 'required',
            'lokasi'           => 'required|string|max:255',
            'jadwal_mulai'     => 'required|date',
            'jadwal_selesai'   => 'required|date|after_or_equal:jadwal_mulai',
            'kuota'            => 'required|integer|min:1',
            'is_active'        => 'required|boolean',
            'thumbnail'        => 'required|image|mimes:jpg,jpeg,png|max:5048',
            'program_bahasa'   => 'required|in:inggris,jerman,mandarin,arab,nhc',
        ]);


        // Convert features_program ke string jika bentuknya array (misalnya dari checkbox atau textarea multiline)
        if (is_array($request->features_program)) {
            $validated['features_program'] = implode(', ', $request->features_program);
        } else {
            // kalau berupa textarea dipisah newline
            // Simpan fitur sebagai JSON array
            $lines = array_filter(array_map('trim', explode("\n", $request->features_program)));
            $validated['features_program'] = json_encode($lines);
        }

        // Upload thumbnail
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails/program_offline', 'public');
        }

        // Simpan ke database
        ProgramOffline::create($validated);

        return redirect()->route('admin.offline.index')->with('success', 'Program offline berhasil ditambahkan.');
    }


    public function edit(ProgramOffline $offline)
    {
        $features = json_decode($offline->features_program, true) ?? [];
        $offline->features_program = implode("\n", $features);

        return view('admin.programs.offline.edit', compact('offline'));
    }

    public function update(Request $request, ProgramOffline $offline)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:program_offline,slug,' . $offline->id,
            'lama_program' => 'required|string|max:100',
            'kategori' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'features_program' => 'nullable|string',
            'lokasi' => 'required|string|max:255',
            'jadwal_mulai' => 'required|date',
            'jadwal_selesai' => 'required|date|after_or_equal:jadwal_mulai',
            'kuota' => 'required|integer|min:1',
            'is_active' => 'required|in:0,1',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'program_bahasa' => 'required|in:inggris,jerman,mandarin,arab,nhc',
        ]);

        $data = $request->only([
            'nama',
            'slug',
            'lama_program',
            'kategori',
            'harga',
            'lokasi',
            'jadwal_mulai',
            'jadwal_selesai',
            'kuota',
            'is_active',
            'program_bahasa',
        ]);

        // Simpan fitur sebagai JSON array
        $features = array_filter(array_map('trim', explode("\n", $request->input('features_program', ''))));
        $data['features_program'] = json_encode($features);

        // Thumbnail logic
        if ($request->has('hapus_thumbnail')) {
            if ($offline->thumbnail && Storage::disk('public')->exists($offline->thumbnail)) {
                Storage::disk('public')->delete($offline->thumbnail);
            }
            $data['thumbnail'] = null;
        }


        if ($request->hasFile('thumbnail')) {
            if ($offline->thumbnail && Storage::disk('public')->exists($offline->thumbnail)) {
                Storage::disk('public')->delete($offline->thumbnail);
            }

            $path = $request->file('thumbnail')->store('thumbnails/program_offline', 'public');
            $data['thumbnail'] = $path;
        }

        $offline->update($data);

        return redirect()->route('admin.offline.index')->with('success', 'Program berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $program = ProgramOffline::findOrFail($id);

        // Hapus thumbnail jika ada
        if ($program->thumbnail && Storage::disk('public')->exists($program->thumbnail)) {
            Storage::disk('public')->delete($program->thumbnail);
        }

        // Hapus permanen (bukan soft delete)
        $program->delete();

        return redirect()->route('admin.offline.index')->with('success', 'Program offline berhasil dihapus.');
    }
    public function byLanguage($bahasa)
    {
        // Contoh: ambil data program offline berdasarkan bahasa
        $programs = ProgramOffline::where('tipe', 'offline')
            ->where('bahasa', $bahasa)
            ->get();

        return view('program.offline', compact('programs', 'bahasa'));
    }
}
