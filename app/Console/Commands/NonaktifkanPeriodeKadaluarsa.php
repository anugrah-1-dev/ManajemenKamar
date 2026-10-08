<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Period;
use Carbon\Carbon;

class NonaktifkanPeriodeKadaluarsa extends Command
{
    protected $signature = 'periode:nonaktifkan';
    protected $description = 'Nonaktifkan periode yang sudah lewat secara otomatis';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $affected = DB::table('periods')
            ->where('date', '<', $today)
            ->where('is_active', 1)
            ->update(['is_active' => 0]);

        $this->info("Jumlah periode yang dinonaktifkan: {$affected}");
    }
}
