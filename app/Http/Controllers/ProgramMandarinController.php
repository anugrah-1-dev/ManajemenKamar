<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramOnline;
use App\Models\ProgramOffline;


class ProgramMandarinController extends Controller
{
    public function showMandarin()
    {
        $onlinePrograms = ProgramOnline::where('program_bahasa', 'Mandarin')
            ->where('is_active', 1)
            ->get();

        $offlinePrograms = ProgramOffline::where('program_bahasa', 'Mandarin')
            ->where('is_active', 1)
            ->get();

        return view('Landingpage.mandarin', compact('onlinePrograms', 'offlinePrograms'));
    }
}
