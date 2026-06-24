<?php

namespace App\Http\Controllers;

// Import kelas yang dibutuhkan
use App\Models\ProgramOffline;
use App\Models\Transports;
use App\Models\Period;
use App\Models\PendaftaranProgramOffline;
use App\Models\Banks;
use App\Models\Customer_Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\ProgramCamp;
use Illuminate\Support\Facades\Http;
use App\Models\PeriodNHC;


class ProgramOfflinePublicController extends Controller
{
    /**
     * Menampilkan detail program offline beserta form pendaftaran.
     */
    public function showOfflinePublic(ProgramOffline $program)
    {
        $transports = Transports::all();
        $periods = Period::where('is_active', 1)->get();
        $activePeriodsNHC = PeriodNHC::where('is_active', 1)->get(); // <── ini tambahan
        $banks = Banks::where('status', 'active')->get();
        $contactServices = Customer_Service::all();
        $camps = ProgramCamp::all();

        return view('programs.offline.show', compact(
            'program',
            'transports',
            'periods',
            'activePeriodsNHC',
            'banks',
            'contactServices',
            'camps'
        ));
    }



    /**
     * Memproses pendaftaran untuk program offline.
     */
    public function daftar(Request $request, ProgramOffline $program)
    {
        // Validation rules
        $rules = [
            'nama_lengkap'   => 'required|string|max:255',
            'email'          => 'required|email',
            'no_hp'          => 'required|string|max:20',
            'asal_kota'      => 'nullable|string|max:100',
            'tempat_lahir'   => 'required|string|max:100',
            'tanggal_lahir'  => 'required|date',
            'gender'         => 'required|in:Laki-laki,Perempuan',
            'no_wali'        => 'nullable|string|max:20',
            'transport_id'   => 'nullable|exists:transports,id',
            'payment_type'   => 'required|in:tunai,transfer,qris',
            'bank_id'        => 'required_if:payment_type,transfer|nullable|exists:banks,id',
            'akomodasi'      => 'nullable|string',
            'ukuran_seragam' => 'nullable|in:S,M,L,XL,XXL',
            'payment_method' => 'nullable|in:full,cicilan,dp',
            'dp_amount'      => 'nullable|numeric',
            'installment_months' => 'nullable|integer|min:1',
        ];


        // Periode dinamis
        if (strtolower($program->program_bahasa) === 'nhc') {
            $rules['period_nhc_id'] = 'required|exists:periods_nhc,id';
        } else {
            $rules['period_id'] = 'required|exists:periods,id';
        }

        $validated = $request->validate($rules);

        // Cek kuota
        if ($program->kuota <= 0) {
            return redirect()->back()->with('error', 'Kuota untuk program ini sudah habis!');
        }

        // TRX ID
        $today = Carbon::now()->format('Ymd');
        $prefix = 'TRX-OFF-' . $today . '-';
        $lastRegistration = PendaftaranProgramOffline::where('trx_id', 'like', $prefix . '%')->orderBy('id', 'desc')->first();
        $nextSequence = $lastRegistration ? (int) str_replace($prefix, '', $lastRegistration->trx_id) + 1 : 1;
        $newTrxId = $prefix . $nextSequence;

        // Hitung harga dasar
        $programPrice = $program->harga;
        $transportPrice = 0;

        if (!empty($validated['transport_id'])) {
            $transport = Transports::find($validated['transport_id']);
            $transportPrice = $transport ? $transport->price : 0;
        }

        $akomodasiTipe = null;
        $akomodasiHarga = 0;
        if (!empty($validated['akomodasi'])) {
            if ($validated['akomodasi'] === 'reguler') {
                $akomodasiTipe = 'Reguler';
                $akomodasiHarga = 180000;
            } elseif (str_starts_with($validated['akomodasi'], 'camp-')) {
                $campId = str_replace('camp-', '', $validated['akomodasi']);
                // load dari DB jika aktif
            }
        }

        // Subtotal final
        $subtotal = $programPrice + $transportPrice + $akomodasiHarga;

        // Default (full payment)
        // Hitung DP
        // === HITUNG DP / CICILAN ===
        $dpAmount = $subtotal; // default full payment
        if (($validated['payment_method'] ?? 'full') === 'cicilan') {
            // DP cicilan = request dp_amount atau default 50%
            $dpAmount = $validated['dp_amount'] ?? round($subtotal * 0.5);
        } elseif (($validated['payment_method'] ?? 'full') === 'dp') {
            // DP fixed = request dp_amount atau fallback 500k
            $dpAmount = $validated['dp_amount'] ?? 500000;
        }
        // $dpAmount = $validated['dp_amount'] ?? null;

        // if (($validated['payment_method'] ?? 'full') === 'cicilan') {
        //     // Kalau dp_amount tidak dikirim, hitung default 50% (atau 30%)
        //     $dpAmount = $dpAmount ?? round($subtotal * 0.5); // 50% sesuai bisnis kamu
        // } else {
        //     $dpAmount = $subtotal;
        // }


        // dd($request->all());
        // dd($request->all());

        // Simpan pendaftaran
        $pendaftaran = PendaftaranProgramOffline::create([
            'trx_id'           => $newTrxId,
            'program_id'       => $program->id,
            'period_id'        => $program->program_bahasa !== 'nhc' ? ($validated['period_id'] ?? null) : null,
            'period_nhc_id'    => $program->program_bahasa === 'nhc' ? ($validated['period_nhc_id'] ?? null) : null,
            'transport_id'     => $validated['transport_id'] ?? null,
            'nama_lengkap'     => $validated['nama_lengkap'],
            'email'            => $validated['email'],
            'no_hp'            => $validated['no_hp'],
            'asal_kota'        => $validated['asal_kota'] ?? null,
            'tempat_lahir'     => $validated['tempat_lahir'],
            'tanggal_lahir'    => $validated['tanggal_lahir'],
            'gender'           => $validated['gender'],
            'no_wali'          => $validated['no_wali'] ?? null,
            'status'           => 'pending',
            'payment_type'     => $validated['payment_type'],
            'bank_id'          => $validated['bank_id'] ?? null,
            'akomodasi_tipe'   => $akomodasiTipe,
            'akomodasi_harga'  => $akomodasiHarga,
            'subtotal'         => $subtotal,
            'ukuran_seragam'   => $validated['ukuran_seragam'] ?? null,
            'payment_method' => $validated['payment_method'] ?? 'full',
            'dp_amount'         => $dpAmount,
            'installment_months' => $validated['installment_months'] ?? null,

        ]);

        if ($validated['payment_method'] === 'cicilan') {
            $dpAmount = $validated['dp_amount'] ?? round($subtotal * 0.5);
        } elseif ($validated['payment_method'] === 'dp') {
            $dpAmount = 500000; // fixed sesuai radio
        } else {
            $dpAmount = $subtotal; // full payment
        }


        // === SIMPAN CICILAN OTOMATIS JIKA CICILAN ===
        if ($pendaftaran->payment_method === 'cicilan') {
            $sisa = $subtotal - $pendaftaran->dp_amount;

            // Simpan hanya 1 cicilan (semua sisa dibayar bulan depan)
            $pendaftaran->cicilan()->create([
                'bulan_ke' => 1, // selalu 1 karena cuma 1x cicilan
                'jumlah' => $sisa, // langsung full sisa, bukan dibagi
                'status' => 'pending',
                'metode_pembayaran' => $pendaftaran->payment_type,
                'tanggal_jatuh_tempo' => now()->addMonth(), // bulan depan
            ]);
        }



        //konsep 3 juta perbulannya
        // if ($pendaftaran->payment_method === 'cicilan') {
        //     $sisa = $subtotal - $pendaftaran->dp_amount;
        //     $bulan = $pendaftaran->installment_months ?? 2;

        //     // Tidak ada bunga → bagi rata saja
        //     $perBulan = $sisa / $bulan;

        //     for ($i = 1; $i <= $bulan; $i++) {
        //         $pendaftaran->cicilan()->create([
        //             'bulan_ke' => $i,
        //             'jumlah' => round($perBulan, 0), // bulatkan ke angka terdekat
        //             'status' => 'pending',
        //             'metode_pembayaran' => $pendaftaran->payment_type,
        //             'tanggal_jatuh_tempo' => now()->addMonths($i),
        //         ]);
        //     }
        // }

        //ini dibayar 2x
        //
        // if ($pendaftaran->payment_method === 'cicilan') {
        //     $sisa = $subtotal - $pendaftaran->dp_amount;
        //     $bulan = $pendaftaran->installment_months ?? 2;

        //     // Tidak ada bunga → langsung simpan sisa penuh tiap bulan
        //     for ($i = 1; $i <= $bulan; $i++) {
        //         $pendaftaran->cicilan()->create([
        //             'bulan_ke' => $i,
        //             'jumlah' => $sisa, // langsung total sisa, bukan dibagi rata
        //             'status' => 'pending',
        //             'metode_pembayaran' => $pendaftaran->payment_type,
        //             'tanggal_jatuh_tempo' => now()->addMonths($i),
        //         ]);
        //     }
        // }


        // Kurangi kuota
        $program->decrement('kuota');
        $program->refresh();
        if ($program->kuota <= 0 && $program->is_active == 1) {
            $program->update(['is_active' => 0]);
        }

        $programName = $pendaftaran->program->nama ?? 'Tidak ada program';
        if (strtolower($program->program_bahasa) === 'nhc') {
            $period = PeriodNHC::find($pendaftaran->period_nhc_id);
        } else {
            $period = Period::find($pendaftaran->period_id);
        }
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
        if ($periodDate) {
            $message .= "*Tanggal Pendaftaran:* " . $periodDate->format('d M Y') . "\n";
        } else {
            $message .= "*Tanggal Pendaftaran:* -\n"; // fallback
        }
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

        // Redirect sesuai jenis pembayaran
        if ($pendaftaran->payment_type === 'tunai') {
            return redirect()->route('public.pendaftaran.offline.sukses.tunai', [
                'trx_id' => $pendaftaran->trx_id
            ]);
        } elseif ($pendaftaran->payment_method === 'dp') {
            return redirect()->route('public.pendaftaran.offline.dp', [
                'trx_id' => $pendaftaran->trx_id
            ]);
        } else {
            return redirect()->route('public.pendaftaran.offline.pembayaran', [
                'trx_id' => $newTrxId
            ])->with('trx_id', $newTrxId);
        }
    }


    /**
     * Menampilkan halaman pembayaran berdasarkan trx_id.
     */
    public function halamanPembayaran($trx_id)
    {
        $pendaftaran = PendaftaranProgramOffline::with(['program', 'bank', 'cicilan'])
            ->where('trx_id', $trx_id)
            ->firstOrFail();

        if ($pendaftaran->payment_type === 'tunai') {
            return redirect()->route('public.pendaftaran.offline.sukses.tunai', ['trx_id' => $pendaftaran->trx_id]);
        }

        $dueLabel = 'Total Pembayaran';
        $amountToPay = 0;

        if ($pendaftaran->payment_method === 'cicilan') {
            // 1. Kalau belum bayar DP
            if (!$pendaftaran->dp_paid) {
                $amountToPay = $pendaftaran->dp_amount;
                $dueLabel = 'DP (Pembayaran Awal)';
            } else {
                // 2. Cari cicilan pertama yang belum dibayar
                $nextCicilan = $pendaftaran->cicilan
                    ->where('status', 'pending')
                    ->sortBy('bulan_ke')
                    ->first();

                if ($nextCicilan) {
                    $amountToPay = $nextCicilan->jumlah;
                    $dueLabel = 'Cicilan Bulan ke-' . $nextCicilan->bulan_ke;
                } else {
                    // 3. Semua cicilan sudah lunas
                    $amountToPay = 0;
                    $dueLabel = 'Sudah Lunas';
                }
            }
        } else {
            // Full payment
            $amountToPay = $pendaftaran->subtotal;
            $dueLabel = 'Total Pembayaran (Full)';
        }

        $contactServices = Customer_Service::all();
        return view('pembayaran.index', compact('pendaftaran', 'contactServices', 'amountToPay', 'dueLabel'));
    }



    /**
     * METHOD BARU: Menampilkan halaman sukses untuk pembayaran tunai.
     */
    public function halamanSuksesTunai($trx_id)
    {
        $pendaftaran = PendaftaranProgramOffline::with('program')
            ->where('trx_id', $trx_id)
            ->where('payment_type', 'tunai') // Pastikan ini adalah pendaftaran tunai
            ->firstOrFail();

        // Tampilkan view baru untuk sukses tunai
        return view('pembayaran.sukses_tunai', compact('pendaftaran'));
    }

    public function halamanqris($trx_id)
    {
        $pendaftaran = PendaftaranProgramOffline::where('trx_id', $trx_id)->firstOrFail();

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
