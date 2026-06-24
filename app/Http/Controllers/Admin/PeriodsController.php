<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Period;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeriodsController extends Controller
{
    // TAMPILKAN DATA
    public function index()
    {
        $periods = Period::orderBy('date', 'desc')->paginate(10);
        return view('admin.periods.index', compact('periods'));
    }

    // TAMBAH DATA
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|unique:periods,date',
        ], [
            'date.unique' => 'Tanggal tersebut sudah digunakan.',
        ]);

        $date = Carbon::parse($request->date);
        $isActive = $request->boolean('is_active'); // ✅ hanya true kalau dicentang

        // TIDAK PAKSA NONAKTIF
        // jadi walaupun date lewat, tetap ikut pilihan admin
        // ini bikin kamu bisa aktifkan periode yang sudah lewat

        Period::create([
            'date' => $date,
            'is_active' => $isActive,
        ]);

        return redirect()->back()->with('alert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Periode berhasil ditambahkan.'
        ]);
    }


    // UPDATE DATA
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date|unique:periods,date,' . $id,
        ]);

        $date = Carbon::parse($request->date);
        $isActive = $request->boolean('is_active'); // ✅ tetap bisa aktif walau sudah lewat

        $period = Period::findOrFail($id);
        $period->update([
            'date' => $date,
            'is_active' => $isActive,
        ]);

        return redirect()->back()->with('alert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Periode berhasil diperbarui.'
        ]);
    }

    // HAPUS DATA
    public function destroy($id)
    {
        $period = Period::findOrFail($id);
        $period->delete();

        return redirect()->back()->with('alert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Periode berhasil dihapus.'
        ]);
    }
}
