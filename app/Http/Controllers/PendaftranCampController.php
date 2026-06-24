<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\ProgramCamp;
use App\Models\Period;
use App\Models\PendaftaranProgramCamp;
use App\Models\Banks;
use App\Models\Rooms;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;


class PendaftranCampController extends Controller
{
    /**
     * Menampilkan halaman detail program camp dan form pendaftaran awal.
     */
    public function showCampPublic(ProgramCamp $program)
    {
        $periods = Period::all(); // bisa filter jika perlu hanya yang aktif
        return view('camp.show', compact('program', 'periods'));
    }

    /**
     * Menangani pendaftaran awal program camp (tanpa upload bukti).
     */
    public function showForm(ProgramCamp $program)
    {
        $periods = Period::where('is_active', true)->get();
        return view('camp.register', compact('program', 'periods'));
    }

    /**
     * Menyimpan data pendaftaran awal dan redirect ke halaman pemilihan kamar.
     */


    public function store(Request $request, ProgramCamp $program)
    {
        $validated = $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'no_hp'          => 'required|string|max:20',
            'asal_kota'      => 'required|string|max:100',
            'period_id'      => 'required|exists:periods,id',
            'durasi_paket'   => 'required|in:perhari,satu_minggu,dua_minggu,tiga_minggu,satu_bulan,dua_bulan,tiga_bulan,enam_bulan,satu_tahun',
            'gender'         => 'required|in:putra,putri',
            'payment_type' => 'required|in:tunai,nontunai',
            'bank_id'      => 'nullable|required_if:payment_type,nontunai|exists:banks,id',
        ], [
            'bank_id.required_if' => 'Bank harus dipilih jika metode pembayaran non tunai.',
        ]);

        // Cek stok terlebih dahulu
        if ($program->stok <= 0) {
            return redirect()->back()->with('error', 'Stok program camp sudah habis!');
        }

        // Buat trx_id
        $prefix = 'TRXC-' . now()->format('Ymd') . '-';
        $last = PendaftaranProgramCamp::where('trx_id', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();
        $nextNumber = $last ? ((int) str_replace($prefix, '', $last->trx_id) + 1) : 1;
        $trx_id = $prefix . $nextNumber;


        
        // Simpan pendaftaran
        $pendaftaran = PendaftaranProgramCamp::create([
            'nama_lengkap'     => $validated['nama_lengkap'],
            'email'            => $validated['email'],
            'no_hp'            => $validated['no_hp'],
            'asal_kota'        => $validated['asal_kota'],
            'gender'           => $validated['gender'],
            'program_camp_id'  => $program->id,
            'period_id'        => $validated['period_id'],
            'durasi_paket'     => $validated['durasi_paket'],
            'bank_id'          => $validated['bank_id'],
            'payment_type'     => $validated['payment_type'],
            'status'           => 'pending',
            'nama_kamar'       => null,
            'trx_id'           => $trx_id,
        ]);


        $programcamp = $pendaftaran->program->nama ?? 'Tidak ada program';
        $line = str_repeat('-', 64);
        $period = Period::find($pendaftaran->period_id);
        $periodDate = $period ? $period->date : null;

        // Pesan lebih rapi
        $message = "📢 *Pendaftaran Baru* 📢\n";
        $message .= "{$line}\n";
        $message .= "*No Transaksi:* {$pendaftaran->trx_id}\n";
        $message .= "{$line}\n";
        // $waNumber = preg_replace('/^0/', '62', preg_replace('/\D/', '', $pendaftaran->no_hp));
        // $waLink = "https://wa.me/{$waNumber}";
        // $message .= "*No HP:* [{$pendaftaran->no_hp}]({$waLink})\n";
        $message .= "No HP: {$pendaftaran->no_hp}\n";
        $message .= "Program: " . $programcamp . "\n";
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


        // Kurangi stok
        $program->decrement('stok');

        return redirect()->route('camp.room', ['trx_id' => $pendaftaran->trx_id]);
    }

    public function halamanKamar($trx_id)
    {
        $pendaftar = PendaftaranProgramCamp::where('trx_id', $trx_id)->firstOrFail();
        $rooms = Rooms::where('program_camp_id', $pendaftar->program_camp_id)->get();

        // Ambil semua pendaftar di program camp ini
        $allPendaftar = PendaftaranProgramCamp::whereNotNull('room_id')
            ->where('program_camp_id', $pendaftar->program_camp_id)
            ->get();

        // Durasi paket ke hari
        $durasiToDays = [
            'perhari' => 1,
            'satu_minggu' => 7,
            'dua_minggu' => 14,
            'tiga_minggu' => 21,
            'empat_minggu' => 28,
            'satu_bulan' => 30,
            'dua_bulan' => 60,
            'tiga_bulan' => 90,
            'enam_bulan' => 180,
            'satu_tahun' => 365,
        ];

        // Hitung penghuni aktif per kamar
        $penghuniAktifPerRoom = [];

        foreach ($allPendaftar as $p) {
            $durasi = $durasiToDays[$p->durasi_paket] ?? 0;
            $endDate = Carbon::parse($p->updated_at)->addDays($durasi);

            if (now()->lessThanOrEqualTo($endDate)) {
                $penghuniAktifPerRoom[$p->room_id] = ($penghuniAktifPerRoom[$p->room_id] ?? 0) + 1;
            }
        }

        return view('camp.room', [
            'rooms' => $rooms,
            'pendaftar' => $pendaftar,
            'trx_id' => $trx_id,
            'penghuniAktifPerRoom' => $penghuniAktifPerRoom, // dikirim ke blade
        ]);
    }



    public static function filter($rooms, $prefix, $start, $end, $gender = null)
    {
        return $rooms->filter(function ($room) use ($prefix, $start, $end, $gender) {
            $number = (int) filter_var($room->nomor_kamar, FILTER_SANITIZE_NUMBER_INT);
            return Str::startsWith($room->nomor_kamar, $prefix)
                && $number >= $start && $number <= $end
                && ($gender ? $room->gender === $gender : true);
        });
    }

    /**
     * Menampilkan halaman pembayaran akhir.
     */

    public function proseskamaruser(Request $request)
    {
        $request->validate([
            'kamar_id' => 'required|exists:rooms,id',
        ]);

        $pendaftar = PendaftaranProgramCamp::where('trx_id', $request->trx_id)->firstOrFail();
        $room = Rooms::findOrFail($request->kamar_id);

        // Mapping durasi ke hari
        $durasiToDays = [
            'perhari' => 1,
            'satu_minggu' => 7,
            'dua_minggu' => 14,
            'tiga_minggu' => 21,
            'empat_minggu' => 28,
            'satu_bulan' => 30,
            'dua_bulan' => 60,
            'tiga_bulan' => 90,
            'enam_bulan' => 180,
            'satu_tahun' => 365,
        ];

        // Hitung penghuni aktif
        $penghuniAktif = PendaftaranProgramCamp::where('room_id', $room->id)
            ->get()
            ->filter(function ($p) use ($durasiToDays) {
                $durasi = $durasiToDays[$p->durasi_paket] ?? 0;
                $endDate = Carbon::parse($p->updated_at)->addDays($durasi);
                return now()->lessThanOrEqualTo($endDate);
            })
            ->count();

        if ($penghuniAktif >= $room->kapasitas) {
            return redirect()->back()->with('error', 'Kamar sudah penuh!');
        }

        // Update data pendaftar + start date countdown
        $pendaftar->update([
            'room_id'    => $room->id,
            'nama_kamar' => $room->nomor_kamar,
            'updated_at' => now(), // start countdown sekarang
        ]);

        $room->increment('penghuni', 1);

        if ($penghuniAktif + 1 >= $room->kapasitas) {
            $program = ProgramCamp::findOrFail($room->program_camp_id);
            if ($program->stok > 0) {
                $program->decrement('stok');
            }
        }

        return redirect()->route('camp.pembayaran', ['trx_id' => $request->trx_id])
            ->with('success', 'Kamar berhasil dipilih!');
    }


    public function halamanPembayaran($trx_id)
    {
        $pendaftaran = PendaftaranProgramCamp::with('bank')
            ->where('trx_id', $trx_id)
            ->firstOrFail();

        $paymentType = $pendaftaran->payment_type; // ambil langsung dari kolom payment_type

        if ($paymentType === 'tunai') {
            return view('camp.tunai', compact('pendaftaran'));
        }

        return view('camp.pembayaran', compact('pendaftaran'));
    }






    // public function showPembayaran($id)
    // {
    //     $pendaftaran = PendaftaranProgramCamp::with('programCamp')->findOrFail($id);
    //     return view('camp.pembayaran', compact('pendaftaran'));

    // }


    public function uploadBukti(Request $request)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'trx_id' => 'required|exists:pendaftaran_program_camps,trx_id',
        ]);

        $pendaftaran = PendaftaranProgramCamp::where('trx_id', $request->trx_id)->firstOrFail();

        // Simpan file
        $file = $request->file('bukti_pembayaran');
        $path = $file->store('bukti_pembayaran', 'public');

        // Update pendaftaran
        $pendaftaran->update([
            'bukti_pembayaran' => $path,
            'status' => 'menunggu_verifikasi'
        ]);

        // Kembalikan ke halaman yang sama dengan pesan dan trx_id
        return back()
            ->with('success_message', "Bukti pembayaran Anda telah berhasil diunggah.")
            ->with('trx_id', $pendaftaran->trx_id);
    }
}
