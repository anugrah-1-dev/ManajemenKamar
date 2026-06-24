<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PendaftaranBiaya extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_biaya';


    protected $fillable = [
        'pendaftaran_offline_id',
        'pendaftaran_online_id',
        'item',
        'harga',
        'qty',
        'subtotal',
    ];

    // Relasi ke Pendaftaran Offline
    public function pendaftaranOffline()
    {
        return $this->belongsTo(PendaftaranProgramOffline::class, 'pendaftaran_offline_id');
    }

    // Relasi ke Pendaftaran Online
    public function pendaftaranOnline()
    {
        return $this->belongsTo(PendaftaranProgramOnline::class, 'pendaftaran_online_id');
    }


    // public function transport()
    // {
    //     return $this->belongsTo(Transports::class, 'biaya_id');
    // }


    // Ambil Program lewat Pendaftaran Offline
    public function program()
    {
        return $this->hasOneThrough(
            ProgramOffline::class,
            PendaftaranProgramOffline::class,
            'id',           // Foreign key di pendaftaran_offline
            'id',           // Foreign key di program
            'pendaftaran_offline_id', // Local key di pendaftaran_biaya
            'program_id'    // Local key di pendaftaran_offline
        );
    }

    // Ambil Transport lewat Pendaftaran Offline
    public function transport()
    {
        return $this->hasOneThrough(
            Transports::class,
            PendaftaranProgramOffline::class,
            'id',            // Foreign key di pendaftaran_offline
            'id',            // Foreign key di transport
            'pendaftaran_offline_id', // Local key di pendaftaran_biaya
            'transport_id'   // Local key di pendaftaran_offline
        );
    }
}
