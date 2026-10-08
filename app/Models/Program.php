<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    // Arahkan model ke nama tabel yang baru
    protected $table = 'program';

    // Sesuaikan kolom yang bisa diisi
    protected $fillable = [
        'judul',
        'deskripsi',
        'keunggulan',
        'gambar',
        'status',
    ];
}
