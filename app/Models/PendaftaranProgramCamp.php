<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranProgramCamp extends Model
{
    protected $table = 'pendaftaran_program_camp';

    protected $fillable = [
        'trx_id', // tambahkan ini
        'nama_lengkap',
        'email',
        'no_hp',
        'asal_kota',
        'gender',
        'program_camp_id',
        'period_id',
        'durasi_paket',
        'nama_kamar',
        'bukti_pembayaran',
        'status',
        'bank_id',
        'payment_type',
        'room_id',
    ];


    // Relasi ke ProgramCamp
        public function program()
        {
            return $this->belongsTo(ProgramCamp::class, 'program_camp_id');
        }

    // Relasi ke Period
    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    // Relasi ke Bank
    public function bank()
    {
        return $this->belongsTo(Banks::class);
    }

    public function room()
    {
        return $this->belongsTo(Rooms::class, 'room_id');
    }


    public function kamar()
    {
        return $this->belongsTo(Rooms::class, 'room_id');
    }
    public function programCamp()
    {
        return $this->belongsTo(ProgramCamp::class, 'program_camp_id');
    }
}
