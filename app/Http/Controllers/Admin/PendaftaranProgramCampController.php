<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranProgramCamp;
use App\Models\ProgramCamp;
use App\Models\Period;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Exports\PendaftaranCampExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Rooms;
use Illuminate\Support\Facades\Storage;

class PendaftaranProgramCampController extends Controller
{
    public function index()
    {
        // $pendaftar = PendaftaranProgramCamp::with(['programCamp', 'period', 'bank'])->latest()->paginate(10);
        $pendaftar = PendaftaranProgramCamp::all();

        return view('admin.camp.index', compact('pendaftar'));
    }

    public function show($id)
    {
        $pendaftar = PendaftaranProgramCamp::with(['programCamp', 'period', 'bank'])->findOrFail($id);
        return view('admin.camp.show', compact('pendaftar'));
    }

    public function edit($id)
    {
        $pendaftar = PendaftaranProgramCamp::findOrFail($id);
        $statusList = ['pending', 'diterima', 'ditolak'];
        return view('admin.camp.edit', compact('pendaftar', 'statusList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,validasi,diterima,ditolak',
        ]);

        $pendaftar = PendaftaranProgramCamp::findOrFail($id);

        $pendaftar->status = $request->status;

        // Kalau status diterima, set tanggal mulai untuk countdown
        if ($request->status === 'diterima') {
            // Kalau punya relasi period
            $pendaftar->period()->updateOrCreate(
                ['pendaftaran_id' => $pendaftar->id],
                ['date' => now()] // bisa juga pakai Carbon::now()
            );
        }

        $pendaftar->save();

        return redirect()->route('admin.camp.index')->with('success', 'Status berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pendaftar = PendaftaranProgramCamp::findOrFail($id);
        $pendaftar->delete();

        return redirect()->back()->with('success', 'Pendaftar berhasil dihapus.');
    }


    public function showBukti($id)
    {
        $pendaftar = PendaftaranProgramCamp::findOrFail($id);

        // Pastikan file bukti pembayaran ada
        if (empty($pendaftar->bukti_pembayaran) || !Storage::disk('public')->exists($pendaftar->bukti_pembayaran)) {
            abort(404, 'Bukti pembayaran tidak ditemukan.');
        }

        // Ambil path lengkap file di storage
        $path = storage_path('app/public/' . $pendaftar->bukti_pembayaran);
        $mimeType = mime_content_type($path);

        // Tampilkan file secara langsung di browser
        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="bukti-'.$pendaftar->id.'"'
        ]);
    }



    public function exportCamp(Request $request)
    {
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        if (!$start || !$end) {
            return redirect()->back()->with('error', 'Tanggal mulai dan akhir wajib diisi.');
        }

        $filename = "pendaftaran_camp_{$start}_to_{$end}.xlsx";

        return Excel::download(new PendaftaranCampExport($start, $end), $filename);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,validasi,diterima,ditolak',
        ]);

        $pendaftar = PendaftaranProgramCamp::findOrFail($id);
        $oldStatus = $pendaftar->status;
        $newStatus = $request->status;

        // Jika status diubah menjadi ditolak dan peserta sebelumnya sudah pilih kamar
        if ($newStatus === 'ditolak' && $pendaftar->room_id) {
            $room = Rooms::find($pendaftar->room_id);
            if ($room && $room->penghuni > 0) {
                $room->decrement('penghuni');
            }

            $pendaftar->room_id = null;
            $pendaftar->nama_kamar = null;
        }

        $pendaftar->status = $newStatus;
        $pendaftar->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    public function pindahKamar(Request $request, $id)
    {
        $peserta = PendaftaranProgramCamp::findOrFail($id);

        $newRoomId = $request->input('target_room_id');
        $newRoom = Rooms::findOrFail($newRoomId);

        // Validasi jika kamar masih tersedia
        if ($newRoom->penghuni >= $newRoom->kapasitas) {
            return response()->json(['success' => false, 'message' => 'Kamar tujuan penuh.']);
        }

        // Update room lama: -1 penghuni
        $oldRoom = Rooms::find($peserta->room_id);
        if ($oldRoom) {
            $oldRoom->penghuni = max(0, $oldRoom->penghuni - 1); // hindari negatif
            $oldRoom->save();
        }

        // Pindahkan peserta
        $peserta->room_id = $newRoomId;
        $peserta->nama_kamar = $newRoom->nomor_kamar; // ✅ update nama kamar juga
        $peserta->save();

        // Update room baru: +1 penghuni
        $newRoom->penghuni += 1;
        $newRoom->save();

        return response()->json(['success' => true]);
    }
}
