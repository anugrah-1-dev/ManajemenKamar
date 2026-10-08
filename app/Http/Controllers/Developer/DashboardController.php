<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Rooms;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRooms = Rooms::count();
        $activeRooms = Rooms::where('status', 'aktif')->count();
        $totalOccupied = Rooms::sum('penghuni');
        $totalLogs = ActivityLog::count();
        $recentLogs = ActivityLog::with('user')->latest()->take(5)->get();

        return view('developer.dashboard', compact(
            'totalRooms',
            'activeRooms',
            'totalOccupied',
            'totalLogs',
            'recentLogs'
        ));
    }
}