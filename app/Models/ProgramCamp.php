<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProgramCamp extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'program_camp';

    protected $fillable = [
        'nama',
        'slug',
        'kategori',
        'stok',
        'harga_perhari',
        'harga_satu_minggu',
        'harga_dua_minggu',
        'harga_tiga_minggu',
        'harga_satu_bulan',
        'harga_dua_bulan',
        'harga_tiga_bulan',
        'harga_enam_bulan',
        'harga_satu_tahun',
        'fasilitas',
        'thumbnail_id'
    ];

    public function thumbnails()
    {
        return $this->hasMany(Thumbnail::class, 'program_camp_id');
    }

    // 🔹 Ambil gambar pertama (default lama)
    public function getThumbnailUrlAttribute()
    {
        $thumbnail = $this->thumbnails->first()->image ?? null;

        if ($thumbnail) {
            if (Str::startsWith($thumbnail, 'storage/')) {
                return asset($thumbnail);
            }
            return asset('storage/upload/camp/' . $thumbnail);
        }

        return asset('images/placeholder.jpg');
    }

    // 🔹 Ambil semua gambar untuk carousel/pagination
    public function getThumbnailUrlsAttribute()
    {
        return $this->thumbnails->map(function ($thumb) {
            $path = $thumb->image;
            if (Str::startsWith($path, 'storage/')) {
                return asset($path);
            }
            return asset('storage/upload/camp/' . $path);
        });
    }
}
