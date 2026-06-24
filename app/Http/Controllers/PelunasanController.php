<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banks;
use App\Models\CicilanProgramOffline;

class PelunasanController extends Controller
{
    // Tampilkan form pelunasan untuk 1 cicilan
    public function show($id)
    {
        $cicilan = CicilanProgramOffline::findOrFail($id);
        $bank = Banks::first(); // Ambil data bank pertama

        return view('pembayaran.pelunasan', compact('cicilan', 'bank'));
    }

    // Proses pelunasan semua cicilan berdasarkan pendaftaran
    public function store(Request $request, $pendaftaran_id)
    {
        // Validasi request
        $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
    
        // Ambil semua cicilan pending dari pendaftaran tertentu
        $cicilanPending = CicilanProgramOffline::where('pendaftaran_program_offline_id', $pendaftaran_id)
            ->where('status', 'pending')
            ->get();
    
        if ($cicilanPending->isEmpty()) {
            return back()->with('error', 'Tidak ada cicilan yang perlu dilunasi.');
        }
    
        // Handle file upload
        $filePath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('bukti_pembayaran', $fileName, 'public');
        }
    
        // Update status semua cicilan pending → pakai helper di model
        foreach ($cicilanPending as $cicilan) {
            $cicilan->markAsPaid($filePath);
        }
        return redirect()->route('tracking.show', $pendaftaran_id)
        ->with('success', 'Pelunasan cicilan Anda telah berhasil');
        // return redirect()->route('tracking.index')->with('success', 'Pelunasan berhasil dilakukan.');
    }
}