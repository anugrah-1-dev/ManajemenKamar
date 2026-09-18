<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranProgramCamp;
use App\Models\PendaftaranProgramOffline;
use App\Models\PendaftaranProgramOnline;

class TrackingController extends Controller
{
    public function index()
    {
        return view('tracking.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'trx_id' => 'required|string',
        ]);

        $trx_id = $request->trx_id;

        $camp = PendaftaranProgramCamp::where('trx_id', $trx_id)->first();
        $offline = PendaftaranProgramOffline::where('trx_id', $trx_id)->first();
        $online = PendaftaranProgramOnline::where('trx_id', $trx_id)->first();

        if (!$camp && !$offline && !$online) {
            return back()->with('error', 'Transaksi tidak ditemukan.');
        }

        return view('tracking.index', compact('camp', 'offline', 'online', 'trx_id'));
    }

    public function show($trx_id)
    {
        // Ambil pendaftaran offline beserta relasi
        $offline = PendaftaranProgramOffline::with('cicilan', 'program', 'transport')
            ->where('trx_id', $trx_id)
            ->first();

        if (!$offline) {
            return redirect()->route('tracking.index')
                ->with('error', 'Transaksi tidak ditemukan.');
        }

        // **Reload cicilan terbaru**
        $offline->load('cicilan');

        // Ambil cicilan yang pending (belum dibayar)
        $pendingCicilan = $offline->cicilan->where('status', 'pending')->sortBy('bulan_ke')->first();

        // Ambil riwayat cicilan yang sudah dibayar
        $riwayatPembayaran = $offline->cicilan->where('status', 'paid')->sortBy('bulan_ke');
        // Tentukan class badge berdasarkan payment_method
        $offline->payment_class = match ($offline->payment_method) {
            'cicilan' => 'bg-warning text-dark',
            'transfer' => 'bg-primary',
            'cash' => 'bg-secondary',
            default => 'bg-secondary',
        };

        // Total harga = subtotal + transport + akomodasi
        $offline->total_harga = ($offline->subtotal ?? 0)
            + ($offline->transport->harga ?? 0)
            + ($offline->akomodasi_harga ?? 0);



        return view('tracking.show', [
            'offline' => $offline,
            'trx_id' => $trx_id,
            'pendingCicilan' => $pendingCicilan,
            'riwayatPembayaran' => $riwayatPembayaran,
            'cicilan' => $offline->cicilan,
        ]);
    }
}
