<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranProgramOffline;
use Illuminate\Http\Request;
use App\Exports\PendaftaranOfflineExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\ProgramOffline;
use App\Models\PeriodNHC;

class PendaftaranOfflineController extends Controller
{
    public function index()
    {
        $pendaftar = PendaftaranProgramOffline::with(['program', 'period'])
            ->latest()->paginate(10);
        $programBahasa = ProgramOffline::select('program_bahasa')
            ->distinct()
            ->pluck('program_bahasa');

        return view('admin.pendaftaran_offline.index', compact('pendaftar', 'programBahasa'));
    }

    public function show($id)
    {
        $pendaftaran = PendaftaranProgramOffline::with(['program', 'cicilan'])->findOrFail($id);
        return view('admin.pendaftaran_offline.show', compact('pendaftaran'));
    }


    /**
     * Menampilkan halaman untuk mengedit status pendaftaran.
     */


    /**
     * Menampilkan halaman untuk mengedit status pendaftaran.
     */
    public function edit($id)
    {

        $pendaftaran = PendaftaranProgramOffline::findOrFail($id);

        // Cek apakah programnya NHC
        if ($pendaftaran->program_bahasa === 'nhc') {
            $periode = PeriodNHC::find($pendaftaran->period_nhc_id);
        } else {
            $periode = optional($pendaftaran->period); // pakai relasi default
        }


        // dd($pendaftaran->program?->program_bahasa, $pendaftaran->period_nhc_id, $pendaftaran->periodNHC);

        return view('admin.pendaftaran_offline.edit', compact('pendaftaran', 'periode'));
    }
    /**
     * Memperbarui status pendaftaran di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);

        $pendaftaran = PendaftaranProgramOffline::findOrFail($id);

        $statusMapping = [
            'approved' => 'diterima',
            'rejected' => 'ditolak',
            'pending' => 'pending',
        ];

        $pendaftaran->status = $statusMapping[$request->status] ?? 'pending';
        $pendaftaran->save();

        return redirect()->route('admin.pendaftaran.offline.index')
            ->with('success', 'Status pendaftaran ' . $pendaftaran->trx_id . ' berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = PendaftaranProgramOffline::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.pendaftaran.offline.index')->with('success', 'Data pendaftaran berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $start = $request->input('start_date');
        $end   = $request->input('end_date');
        $programBahasa = $request->input('program_bahasa'); // ambil dari form

        if (!$start || !$end) {
            return redirect()->back()->with('error', 'Tanggal harus diisi!');
        }

        $filename = "pendaftaran_offline_{$start}_to_{$end}.xlsx";

        return Excel::download(new PendaftaranOfflineExport($start, $end, $programBahasa), $filename);
    }


    /**
     * Menampilkan bukti pembayaran dari database.
     */


    public function showBukti($id)
    {
        $pendaftaran = PendaftaranProgramOffline::findOrFail($id);

        if (empty($pendaftaran->bukti_pembayaran_path) || !Storage::disk('public')->exists($pendaftaran->bukti_pembayaran_path)) {
            abort(404, 'Bukti pembayaran tidak ditemukan.');
        }

        // Ambil file dari storage
        $path = storage_path('app/public/' . $pendaftaran->bukti_pembayaran_path);
        $mimeType = mime_content_type($path);

        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="bukti-' . $pendaftaran->trx_id . '"'
        ]);
    }

    public function showDP($id)
    {
        $pendaftaran = PendaftaranProgramOffline::with(['program', 'cicilan', 'dp'])
            ->findOrFail($id);
    
        return view('admin.pendaftaran_offline.DP', compact('pendaftaran'));
    }
    

}
