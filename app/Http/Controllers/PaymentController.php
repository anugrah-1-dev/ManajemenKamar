<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranProgramOnline;
use App\Models\PendaftaranProgramOffline;
use App\Models\PendaftaranProgramCamp;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Direkomendasikan untuk logging

class PaymentController extends Controller
{
    /**
     * Mengunggah bukti pembayaran dan menyimpannya ke database.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadProof(Request $request)
    {
        // 1. Validasi input yang masuk
        try {
            $request->validate([
                'id' => 'required|integer',
                'type' => 'required|in:online,offline,camp',
                'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Maksimal 2MB
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed for payment proof upload: ', $e->errors());
            return back()->with('error', 'Validasi gagal: Pastikan file adalah gambar atau PDF dan ukurannya tidak lebih dari 2MB.');
        }

        // 2. Ambil model pendaftaran berdasarkan tipenya
        $pendaftaran = match ($request->type) {
            'online' => PendaftaranProgramOnline::find($request->id),
            'offline' => PendaftaranProgramOffline::find($request->id),
            'camp' => PendaftaranProgramCamp::find($request->id),
            default => null,
        };

        if (!$pendaftaran) {
            Log::warning("Pendaftaran tidak ditemukan untuk tipe: {$request->type} dan ID: {$request->id}");
            return back()->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        // 3. Simpan file baru dan hapus yang lama jika ada
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');

            // Hapus file lama untuk menghindari penumpukan file tidak terpakai
            if ($pendaftaran->bukti_pembayaran && Storage::disk('public')->exists($pendaftaran->bukti_pembayaran)) {
                Storage::disk('public')->delete($pendaftaran->bukti_pembayaran);
            }

            // Buat nama file yang unik untuk menghindari konflik
            $filename = 'bukti_' . $request->type . '_' . $pendaftaran->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Simpan file ke storage/app/public/bukti_pembayaran
            $path = $file->storeAs('bukti_pembayaran', $filename, 'public');

            // 4. Update database dengan path file baru dan status
            $pendaftaran->bukti_pembayaran = $path;
            $pendaftaran->status = 'pending'; // Status diubah menjadi 'pending' untuk diverifikasi ulang
            $pendaftaran->save();

            // 5. Kembalikan respons dengan pesan dan ID Transaksi secara terpisah
            return back()
                ->with('success_message', "Bukti pembayaran Anda telah berhasil diunggah.")
                ->with('trx_id', $pendaftaran->trx_id);
        }

        // Fallback jika file tidak ada karena alasan yang tidak terduga
        return back()->with('error', 'Gagal mengunggah file. Silakan coba lagi.');
    }
}
