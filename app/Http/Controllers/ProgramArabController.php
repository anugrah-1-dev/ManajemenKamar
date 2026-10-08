<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramOnline;
use App\Models\ProgramOffline;


class ProgramArabController extends Controller
{
    public function showArab()
    {
        $onlinePrograms = ProgramOnline::where('program_bahasa', 'Arab')
            ->where('is_active', 1)
            ->get();

        $offlinePrograms = ProgramOffline::where('program_bahasa', 'Arab')
            ->where('is_active', 1)
            ->get();

        return view('Landingpage.arab', compact('onlinePrograms', 'offlinePrograms'));
    }
}
