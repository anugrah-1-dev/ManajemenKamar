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
            $filename = strtolower(basename($thumbnail));
            $staticFiles = ['ac.jpg', 'barack-beddings.jpeg', 'foto-beddings.jpg', 'foto-beddingss.jpg', 'foto-kloset.jpg', 'lemari.jpg', 'shower-.jpeg', 'shower.jpeg', 'tampak-depan.jpg', 'vip-toilet.jpeg', 'water-heater.jpeg'];
            
            if (in_array($filename, $staticFiles)) {
                return asset('camp/' . $filename);
            }

            if (Str::startsWith($thumbnail, 'storage/')) {
                return asset($thumbnail);
            }

            if (
                file_exists(public_path('camp/' . $filename)) ||
                (isset($_SERVER['DOCUMENT_ROOT']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/camp/' . $filename)) ||
                file_exists(base_path('public_html/camp/' . $filename))
            ) {
                return asset('camp/' . $filename);
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
            
            $filename = strtolower(basename($path));
            $staticFiles = ['ac.jpg', 'barack-beddings.jpeg', 'foto-beddings.jpg', 'foto-beddingss.jpg', 'foto-kloset.jpg', 'lemari.jpg', 'shower-.jpeg', 'shower.jpeg', 'tampak-depan.jpg', 'vip-toilet.jpeg', 'water-heater.jpeg'];
            
            if (in_array($filename, $staticFiles)) {
                return asset('camp/' . $filename);
            }

            if (Str::startsWith($path, 'storage/')) {
                return asset($path);
            }

            if (
                file_exists(public_path('camp/' . $filename)) ||
                (isset($_SERVER['DOCUMENT_ROOT']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/camp/' . $filename)) ||
                file_exists(base_path('public_html/camp/' . $filename))
            ) {
                return asset('camp/' . $filename);
            }
            return asset('storage/upload/camp/' . $path);
        });
    }
}
