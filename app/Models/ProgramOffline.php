<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramOffline extends Model
{
    use HasFactory;

    protected $table = 'program_offline';
    protected $fillable = [
        'nama',
        'slug',
        'lama_program',
        'kategori',
        'harga',
        'features_program',
        'lokasi',
        'jadwal_mulai',
        'jadwal_selesai',
        'kuota',
        'is_active',
        'thumbnail',
        'program_bahasa',
    ];

    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }
}
