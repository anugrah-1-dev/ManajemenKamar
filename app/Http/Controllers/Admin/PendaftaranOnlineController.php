<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramOnline;
use App\Models\Period;
use App\Models\PendaftaranProgramOnline;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use App\Exports\PendaftaranOnlineExport;
use Maatwebsite\Excel\Facades\Excel;


class PendaftaranOnlineController extends Controller
{
    /**
     * Menampilkan daftar pendaftar online.
     */
    public function index()
    {
        $pendaftar = PendaftaranProgramOnline::with(['program'])
            ->latest()->paginate(10);
        $programBahasa = ProgramOnline::select('program_bahasa')
            ->distinct()
            ->pluck('program_bahasa');

        return view('admin.pendaftaran_online.index', compact('pendaftar', 'programBahasa'));
    }

    /**
     * Menampilkan halaman untuk mendaftar (jika diakses dari admin).
     */
    public function create()
    {
        $programs = ProgramOnline::where('is_active', 1)->get();
        // Program online mungkin tidak memerlukan periode, sesuaikan jika perlu
        // $periods = Period::orderBy('date')->get();

        return view('admin.pendaftaran_online.create', compact('programs'));
    }

    /**
     * Menyimpan pendaftaran baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email',
            'no_hp' => 'nullable|string',
            'asal_kota' => 'nullable|string',
            'program_id' => 'required|exists:program_onlines,id', // pastikan nama tabel benar
            'bukti_pembayaran' => 'nullable|image|max:2048',
        ]);

        $pendaftaran = new PendaftaranProgramOnline($validated);
        $pendaftaran->trx_id = 'TRX-ONLINE-' . strtoupper(Str::random(8));
        $pendaftaran->status = 'pending';

        // Simpan file langsung ke database jika ada
        if ($request->hasFile('bukti_pembayaran')) {
            $pendaftaran->bukti_pembayaran = file_get_contents($request->file('bukti_pembayaran')->getRealPath());
        }

        $pendaftaran->save();

        return redirect()->back()->with('success', 'Pendaftaran berhasil! TRX ID: ' . $pendaftaran->trx_id);
    }

    /**
     * Menampilkan halaman untuk mengedit status pendaftaran.
     */
    public function edit($id)
    {
        $pendaftaran = PendaftaranProgramOnline::with(['program'])->findOrFail($id);
        return view('admin.pendaftaran_online.edit', compact('pendaftaran'));
    }

    /**
     * Memperbarui status pendaftaran di database.
     */
   public function update(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:approved,rejected,pending',
    ]);

    $pendaftaran = PendaftaranProgramOnline::findOrFail($id);

    // Mapping status dari input ke nilai yang disimpan di database
    $statusMapping = [
        'approved' => 'diterima',
        'rejected' => 'ditolak',
        'pending' => 'pending',
    ];

    $pendaftaran->status = $statusMapping[$request->status] ?? 'pending';
    $pendaftaran->save();

    return redirect()->route('admin.pendaftaran.online.index')
        ->with('success', 'Status pendaftaran ' . $pendaftaran->trx_id . ' berhasil diperbarui.');
}


    /**
     * Menghapus data pendaftaran.
     */
    public function destroy($id)
    {
        $data = PendaftaranProgramOnline::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.pendaftaran.online.index')->with('success', 'Data pendaftaran berhasil dihapus.');
    }

    /**
     * Menampilkan bukti pembayaran dari database.
     */
    public function showBukti($id)
    {
        $pendaftaran = PendaftaranProgramOnline::findOrFail($id);

        if (empty($pendaftaran->bukti_pembayaran)) {
            abort(404, 'Bukti pembayaran tidak ditemukan.');
        }

        $finfo = finfo_open();
        $mimeType = finfo_buffer($finfo, $pendaftaran->bukti_pembayaran, FILEINFO_MIME_TYPE);
        finfo_close($finfo);

        return Response::make($pendaftaran->bukti_pembayaran, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="bukti-'.$pendaftaran->trx_id.'"'
        ]);
    }

    /**
     * Mengekspor data ke CSV.
     */

    // public function exportOnline(Request $request)
    // {
    //     $start = $request->input('start_date');
    //     $end = $request->input('end_date');

    //     if (!$start || !$end) {
    //         return redirect()->back()->with('error', 'Tanggal mulai dan akhir wajib diisi.');
    //     }

    //     $filename = "pendaftaran_online_{$start}_to_{$end}.xlsx";

    //     return Excel::download(new PendaftaranOnlineExport($start, $end), $filename);
    // }
    public function exportOnline(Request $request)
    {
        $start = $request->input('start_date');
        $end   = $request->input('end_date');
        $programBahasa = $request->input('program_bahasa'); // ambil dari form

        if (!$start || !$end) {
            return redirect()->back()->with('error', 'Tanggal harus diisi!');
        }

        $filename = "pendaftaran_online_{$start}_to_{$end}.xlsx";

        return Excel::download(new PendaftaranOnlineExport($start, $end, $programBahasa), $filename);
    }
}
