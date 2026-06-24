<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dp;
use App\Models\PendaftaranProgramOffline;
use Illuminate\Support\Facades\Log;

class DpController extends Controller
{
    /**
     * Tampilkan halaman upload DP berdasarkan trx_id
     */
    public function dp($trx_id)
{
    // ambil pendaftaran dengan relasi bank & program (agar tidak N+1)
    $pendaftaran = PendaftaranProgramOffline::with(['program', 'bank'])
        ->where('trx_id', $trx_id)
        ->firstOrFail();

    // ambil bank yang terkait dengan pendaftaran (jika ada),
    // lebih aman daripada Banks::first() karena menampilkan bank sesuai pendaftaran
    $bank = $pendaftaran->bank;

    // dp_amount bisa ada di pendaftaran (field dp_amount), gunakan fallback kalau null
    $dpAmount = $pendaftaran->dp_amount ?? ($pendaftaran->program->harga ? $pendaftaran->program->harga / 2 : null);

    return view('pembayaran.dp', compact('pendaftaran', 'bank', 'dpAmount'));
}

public function store(Request $request)
{
    $request->validate([
        'pendaftaran_program_offline_id' => 'required|exists:pendaftaran_program_offline,id',
        'bukti_dp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // max 5MB
    ]);

    try {
        $pendaftaranId = $request->pendaftaran_program_offline_id;

        // Ambil existing dp (jika ada) -> supaya bisa hapus file lama
        $existing = Dp::where('pendaftaran_program_offline_id', $pendaftaranId)->first();

        // Simpan file baru ke storage/app/public/dp
        $path = $request->file('bukti_dp')->store('dp', 'public');

        // Hapus file lama jika ada
        // if ($existing && $existing->bukti_dp && Storage::disk('public')->exists($existing->bukti_dp)) {
        //     Storage::disk('public')->delete($existing->bukti_dp);
        // }

        // Simpan atau update record di tabel dp
        $dp = Dp::updateOrCreate(
            ['pendaftaran_program_offline_id' => $pendaftaranId],
            ['bukti_dp' => $path]
        );

        Log::info('DP tersimpan', ['dp' => $dp->toArray()]);

        return redirect()
            ->route('public.pendaftaran.offline.dp', ['trx_id' => $dp->pendaftaranProgramOffline->trx_id])
            ->with([
                'success_message' => 'Bukti DP berhasil diunggah.',
                'trx_id' => $dp->pendaftaranProgramOffline->trx_id
            ]);

    } catch (\Exception $e) {
        Log::error('Gagal menyimpan bukti DP: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan bukti DP. Coba lagi.');
    }
}

    /**
     * Tampilkan detail bukti DP
     */
    public function show($id)
    {
        $dp = Dp::with(['pendaftaranProgramOffline', 'bank'])->findOrFail($id);

        return view('dp.show', compact('dp'));
    }
}
