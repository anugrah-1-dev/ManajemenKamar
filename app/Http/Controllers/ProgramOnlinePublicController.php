<?php

namespace App\Http\Controllers;

use App\Models\ProgramOnline;
use App\Models\Period;
use App\Models\PendaftaranProgramOnline;
use App\Models\Banks;
use App\Models\Customer_Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ProgramOnlinePublicController extends Controller
{
    /**
     * Menampilkan detail program online.
     */
    public function show(ProgramOnline $program)
    {
        if (!$program->is_active) {
            abort(404);
        }
        $periods = Period::where('is_active', 1)->get();
        $banks = Banks::where('status', 'active')->get();
        $contactServices = Customer_Service::all();

        return view('programs.online.show', compact('program', 'periods', 'banks', 'contactServices'));
    }

    /**
     * Memproses pendaftaran untuk program online.
     */
    public function daftar(Request $request, ProgramOnline $program)
    {
        // Validasi
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email',
            'no_hp'        => 'required|string|max:20',
            'asal_kota'    => 'nullable|string|max:100',
            'period_id'    => 'required|exists:periods,id',
            'payment_type' => 'required|in:tunai,transfer',
            'bank_id'      => 'required_if:payment_type,transfer|nullable|exists:banks,id',
            'akomodasi'    => 'nullable|string', // ✅ pakai string "vip" / "reguler"
        ]);

        // === TRX-ID unik ===
        $today  = Carbon::now()->format('Ymd');
        $prefix = 'TRX-ONL-' . $today . '-';

        $lastRegistration = PendaftaranProgramOnline::where('trx_id', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        $nextSequence = $lastRegistration
            ? (int) str_replace($prefix, '', $lastRegistration->trx_id) + 1
            : 1;

        $newTrxId = $prefix . $nextSequence;

        // === Harga Program ===
        $programPrice = $program->harga ?? 0;

        // === Akomodasi (VIP / Reguler) ===
        $akomodasiTipe  = null;
        $akomodasiHarga = 0;

        if (!empty($validated['akomodasi'])) {
            if ($validated['akomodasi'] === 'vip') {
                $akomodasiTipe  = 'vip';
                $akomodasiHarga = $program->harga_vip ?? 0; // ambil dari kolom program (kalau ada)
            } elseif ($validated['akomodasi'] === 'reguler') {
                $akomodasiTipe  = 'reguler';
                $akomodasiHarga = 180000; // static reguler
            }
        }

        // === Subtotal ===
        $subtotal = $programPrice + $akomodasiHarga;

        // === Simpan ke DB ===
        $pendaftaran = PendaftaranProgramOnline::create([
            'trx_id'          => $newTrxId,
            'program_id'      => $program->id,
            'period_id'       => $validated['period_id'],
            'bank_id'         => $validated['bank_id'] ?? null,
            'nama_lengkap'    => $validated['nama_lengkap'],
            'email'           => $validated['email'],
            'no_hp'           => $validated['no_hp'],
            'asal_kota'       => $validated['asal_kota'] ?? null,
            'payment_type'    => $validated['payment_type'],
            'status'          => 'pending',

            // ✅ field baru
            'akomodasi_tipe'  => $akomodasiTipe,
            'akomodasi_harga' => $akomodasiHarga,
            'subtotal'        => $subtotal,
        ]);

        $programName = $pendaftaran->program->nama ?? 'Tidak ada program';
        $period = Period::find($pendaftaran->period_id);
        $periodDate = $period ? $period->date : null;

        // Buat garis panjang
        $line = str_repeat('-', 64);

        // Pesan lebih rapi
        $message = "📢 *Pendaftaran Baru* 📢\n";
        $message .= "{$line}\n";
        $message .= "*No Transaksi:* {$pendaftaran->trx_id}\n";
        $message .= "{$line}\n";
        $message .= "*Nama:* {$pendaftaran->nama_lengkap}\n";
        $message .= "*Email:* {$pendaftaran->email}\n";
        $message .= "{$line}\n";
        // $waNumber = preg_replace('/^0/', '62', preg_replace('/\D/', '', $pendaftaran->no_hp));
        // $waLink = "https://wa.me/{$waNumber}";
        // $message .= "*No HP:* [{$pendaftaran->no_hp}]({$waLink})\n";
        $message .= "No HP: {$pendaftaran->no_hp}\n";
        $message .= "*Program:* {$programName}\n";
        $message .= "*Tanggal Pendaftaran:* {$periodDate->format('d M Y')}\n";
        $message .= "{$line}\n";

        $message .= "_!>w<!_";

        $chatIds = explode(',', env('TELEGRAM_CHAT_IDS'));

        foreach ($chatIds as $chatId) {
            Http::post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage", [
                'chat_id' => trim($chatId),
                'text'    => $message,
                'parse_mode' => 'Markdown'
            ]);
        }


        // Redirect sesuai metode pembayaran
        if ($pendaftaran->payment_type === 'tunai') {
            return redirect()->route('public.pendaftaran.online.sukses.tunai', ['trx_id' => $pendaftaran->trx_id]);
        } elseif ($pendaftaran->payment_type === 'qris') {
            return redirect()->route('public.pendaftaran.online.sukses.qris', ['trx_id' => $pendaftaran->trx_id]);
        } else {
            return redirect()->route('public.pendaftaran.online.pembayaran', ['trx_id' => $newTrxId])
                ->with('success_message', 'Pendaftaran awal berhasil! Silakan lanjutkan ke tahap pembayaran.');
        }
    }


    /**
     * Menampilkan halaman pembayaran berdasarkan trx_id untuk program online.
     */
    public function halamanPembayaran($trx_id)
    {
        $pendaftaran = PendaftaranProgramOnline::with(['program', 'bank'])
            ->where('trx_id', $trx_id)
            ->firstOrFail();

        // Jika metode pembayaran tunai, langsung redirect ke halaman sukses tunai
        if ($pendaftaran->payment_type === 'tunai') {
            return redirect()->route('public.pendaftaran.online.sukses.tunai', ['trx_id' => $pendaftaran->trx_id]);
        }

        $contactServices = Customer_Service::all();

        return view('pembayaran.index', compact('pendaftaran', 'contactServices'));
    }

    /**
     * Menampilkan halaman sukses untuk pembayaran tunai.
     */
    public function halamanSuksesTunai($trx_id)
    {
        $pendaftaran = PendaftaranProgramOnline::with('program')
            ->where('trx_id', $trx_id)
            ->where('payment_type', 'tunai')
            ->firstOrFail();

        return view('pembayaran.sukses_tunai', compact('pendaftaran'));
    }


    public function halamanqris($trx_id)
    {
        $pendaftaran = PendaftaranProgramOnline::where('trx_id', $trx_id)->firstOrFail();

        // batas waktu = created_at + 10 menit
        $expiresAt = $pendaftaran->created_at->copy()->addMinutes(10);

        // cek expired
        if (now()->greaterThan($expiresAt) || $pendaftaran->status === 'expired') {
            if ($pendaftaran->status !== 'expired') {
                $pendaftaran->update(['status' => 'expired']);
            }

            return redirect()
                ->route('public.program.offline.show', $pendaftaran->program->slug)
                ->with('error', 'Batas waktu pembayaran habis, silakan daftar lagi.');
        }

        $qrisImage   = asset('asset/qris/madarin_qris.jpg');
        $expiresAtTs = $expiresAt->getTimestampMs();
        $nowTs       = now()->getTimestampMs();
        $sudahUpload = !empty($pendaftaran->bukti_pembayaran);

        return view('pembayaran.qris', compact(
            'pendaftaran',
            'qrisImage',
            'expiresAtTs',
            'nowTs',
            'sudahUpload'
        ));
    }
}
