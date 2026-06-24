<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramOnline;
use App\Models\ProgramOffline;

class ProgramNHCController extends Controller
{
    /**
     * Menampilkan halaman landing page NHC beserta data programnya.
     */
    public function index()
    {
        // 1. Mengambil semua program ONLINE yang aktif dan program_bahasa-nya adalah 'NHC'
        $onlinePrograms = ProgramOnline::where('program_bahasa', 'NHC')
            ->where('is_active', 1)
            ->get();

        // 2. Mengambil semua program OFFLINE yang aktif dan program_bahasa-nya adalah 'NHC'
        $offlinePrograms = ProgramOffline::where('program_bahasa', 'NHC')
            ->where('is_active', 1)
            ->get();
            
        // 3. Mengirim kedua data tersebut ke view 'Landingpage.NHC'
        return view('Landingpage.NHC', compact('onlinePrograms', 'offlinePrograms'));
    }
}