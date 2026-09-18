<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodNHC;
use Illuminate\Http\Request;

class PeriodNHCController extends Controller
{
    /**
     * Tampilkan semua periode NHC
     */
    public function index()
    {
        $periods = PeriodNHC::orderBy('start_date', 'desc')->get();
        return view('admin.periods_nhc.index', compact('periods'));
    }

    /**
     * Simpan periode baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
            'is_active'  => 'nullable|boolean',
        ]);

        PeriodNHC::create([
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'is_active'  => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.periods_nhc.index')
            ->with('success', 'Periode baru berhasil ditambahkan!');
    }

    public function update(Request $request, PeriodNHC $periods_nhc)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
            'is_active'  => 'nullable|boolean',
        ]);

        $periods_nhc->update([
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'is_active'  => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.periods_nhc.index')
            ->with('success', 'Periode berhasil diperbarui!');
    }


    /**
     * Hapus periode
     */
    public function destroy(PeriodNHC $periods_nhc)
    {
        $periods_nhc->delete();

        return redirect()->route('admin.periods_nhc.index')
            ->with('success', 'Periode berhasil dihapus!');
    }
}
