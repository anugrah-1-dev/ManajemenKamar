<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramOnline;
use App\Models\ProgramOffline;

class ProgramInggrisController extends Controller
{
    public function showInggris()
    {
        $onlinePrograms = ProgramOnline::where('program_bahasa', 'Inggris')
            ->where('is_active', 1)
            ->get();

        $offlinePrograms = ProgramOffline::where('program_bahasa', 'Inggris')
            ->where('is_active', 1)
            ->get();

        // Convert features_program JSON to array for each program
        foreach ($onlinePrograms as $program) {
            if (!empty($program->features_program)) {
                $decoded = json_decode($program->features_program, true);
                $program->features_program = is_array($decoded) ? $decoded : [];
            } else {
                $program->features_program = [];
            }
        }
        foreach ($offlinePrograms as $program) {
            if (!empty($program->features_program)) {
                $decoded = json_decode($program->features_program, true);
                $program->features_program = is_array($decoded) ? $decoded : [];
            } else {
                $program->features_program = [];
            }
        }

        return view('Landingpage.inggris', compact('onlinePrograms', 'offlinePrograms'));
    }
}
