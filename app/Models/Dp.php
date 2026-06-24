<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dp extends Model
{
    protected $table = 'dp_table';

    protected $fillable = [
        'pendaftaran_program_offline_id',
        'bukti_dp',
    ];

    public function pendaftaranProgramOffline()
    {
        return $this->belongsTo(PendaftaranProgramOffline::class, 'pendaftaran_program_offline_id');
    }
    public function bank()
    {
        return $this->belongsTo(Banks::class, 'bank_id');
    }
}
