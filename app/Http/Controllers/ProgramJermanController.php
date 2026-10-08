<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramOnline;
use App\Models\ProgramOffline;

class ProgramJermanController extends Controller
{
    public function showJerman()
    {
        $onlinePrograms = ProgramOnline::where('program_bahasa', 'Jerman')
            ->where('is_active', 1)
            ->get();

        $offlinePrograms = ProgramOffline::where('program_bahasa', 'Jerman')
            ->where('is_active', 1)
            ->get();

        return view('Landingpage.Jerman', compact('onlinePrograms', 'offlinePrograms'));
    }
}
