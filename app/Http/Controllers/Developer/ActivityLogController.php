<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activityLogs = ActivityLog::with('user')
            ->latest()
            ->paginate(15);

        return view('developer.activity_logs.index', compact('activityLogs'));
    }
}