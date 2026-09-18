<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rooms;
use App\Models\ProgramCamp;
use App\Models\Sosmed;
use App\Models\PendaftaranProgramOnline;
use App\Models\PendaftaranProgramOffline;
use App\Models\PendaftaranProgramCamp;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $pendaftaranOnline = PendaftaranProgramOnline::with('program')->get();
        $pendaftaranOffline = PendaftaranProgramOffline::with('program')->get();
        $pendaftaranCamp = PendaftaranProgramCamp::with('programCamp')->get();

        $years = range(now()->year - 1, now()->year);
        $monthlyProfit = [];
        foreach ($years as $year) {
            $monthlyProfit[$year] = array_fill(1, 12, 0);
        }

        // Hitung keuntungan online
        // Hitung keuntungan online
        foreach ($pendaftaranOnline as $item) {
            if ($item->status !== 'diterima') continue;
            $date = Carbon::parse($item->created_at);
            $monthlyProfit[$date->year][$date->month] += $this->calculateOnlinePrice($item);
        }


        // Hitung keuntungan offline
        foreach ($pendaftaranOffline as $item) {
            if ($item->status !== 'diterima') continue;
            $date = Carbon::parse($item->created_at);
            $monthlyProfit[$date->year][$date->month] += $this->calculateOfflinePrice($item);
        }

        // Hitung keuntungan camp
        foreach ($pendaftaranCamp as $item) {
            if ($item->status !== 'diterima') continue;
            $date = Carbon::parse($item->created_at);
            $harga = $this->calculateCampPrice($item);
            $monthlyProfit[$date->year][$date->month] += $harga;
        }

        // Hitung total data dan keuntungan
        $salesData = [
            'Online' => $pendaftaranOnline->where('status', 'diterima')->count(),
            'Offline' => $pendaftaranOffline->where('status', 'diterima')->count(),
            'Camp' => $pendaftaranCamp->where('status', 'diterima')->count(),
        ];
        $totalKursus = array_sum($salesData);

        $totalKeuntungan = array_reduce(
            $pendaftaranOnline->all(),
            fn($sum, $p) => $sum + (($p->status === 'diterima') ? $this->calculateOnlinePrice($p) : 0),
            0
        ) + array_reduce(
            $pendaftaranOffline->all(),
            fn($sum, $p) => $sum + (($p->status === 'diterima') ? $this->calculateOfflinePrice($p) : 0),
            0
        )
            + array_reduce($pendaftaranCamp->all(), function ($sum, $p) {
                return $sum + (($p->status === 'diterima') ? $this->calculateCampPrice($p) : 0);
            }, 0);

        $totalMediaSosial = 20;
        $sosmedList = Sosmed::latest()->take(12)->get();

        // Ambil list program camp untuk filter dropdown
        $programCamps = ProgramCamp::orderBy('nama')->get();

        // Filter wajib: Program Camp dan Gender
        $stokData = collect(); // default kosong

        if ($request->filled('program_camp_nama') && $request->filled('gender')) {
            $query = Rooms::with('programCamp')->where('gender', $request->gender)
                ->whereHas('programCamp', function ($q) use ($request) {
                    $q->where('nama', $request->program_camp_nama);
                });

            $stokData = $query->get()->map(function ($room) {
                return [
                    'nama_kamar' => $room->nomor_kamar ?? '-',
                    'stok' => max(0, ($room->kapasitas ?? 0) - ($room->penghuni ?? 0)),
                    'kategori' => $room->kategori ?? '-',
                    'program' => optional($room->programCamp)->nama ?? '-',
                    'gender' => $room->gender ?? '-',
                ];
            });
        }

        return view('admin.dashboard', compact(
            'monthlyProfit',
            'salesData',
            'totalKursus',
            'totalKeuntungan',
            'totalMediaSosial',
            'sosmedList',
            'programCamps',
            'stokData'
        ));
    }

    protected function calculateCampPrice($pendaftaranCamp)
    {
        if (!$pendaftaranCamp->programCamp) return 0;

        $durasi = $pendaftaranCamp->durasi_paket;
        $program = $pendaftaranCamp->programCamp;

        switch ($durasi) {
            case 'satu_minggu':
                return $program->harga_satu_minggu ?? 0;
            case 'dua_minggu':
                return $program->harga_dua_minggu ?? 0;
            case 'tiga_minggu':
                return $program->harga_tiga_minggu ?? 0;
            case 'satu_bulan':
                return $program->harga_satu_bulan ?? 0;
            case 'dua_bulan':
                return $program->harga_dua_bulan ?? 0;
            case 'tiga_bulan':
                return $program->harga_tiga_bulan ?? 0;
            case 'enam_bulan':
                return $program->harga_enam_bulan ?? 0;
            case 'satu_tahun':
                return $program->harga_satu_tahun ?? 0;
            case 'perhari':
                return $program->harga_perhari ?? 0;
            default:
                return $program->harga_perhari ?? 0;
        }
    }
    protected function calculateOfflinePrice($pendaftaranOffline)
    {
        if (!$pendaftaranOffline->program) return 0;

        $hargaProgram   = $pendaftaranOffline->program->harga ?? 0;
        $hargaTransport = $pendaftaranOffline->transport->price ?? 0;
        $hargaAkomodasi = $pendaftaranOffline->akomodasi_harga ?? 0;

        return $hargaProgram + $hargaTransport + $hargaAkomodasi;
    }

    // Tambahkan method baru di bawah calculateOfflinePrice
    protected function calculateOnlinePrice($pendaftaranOnline)
    {
        if (!$pendaftaranOnline->program) return 0;

        $hargaProgram   = $pendaftaranOnline->program->harga ?? 0;
        $hargaAkomodasi = $pendaftaranOnline->akomodasi_harga ?? 0;

        return $hargaProgram + $hargaAkomodasi;
    }
}
