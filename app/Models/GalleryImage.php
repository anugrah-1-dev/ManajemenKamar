<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_id',
        'image_path',
        'caption',
    ];

    // Relasi: gambar ini milik satu galeri
    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    // Accessor untuk mendapatkan URL gambar yang benar
    public function getImageUrlAttribute()
    {
        $path = $this->image_path;
        
        $filename = strtolower(basename($path));
        $staticFiles = ['ac.jpg', 'barack-beddings.jpeg', 'foto-beddings.jpg', 'foto-beddingss.jpg', 'foto-kloset.jpg', 'lemari.jpg', 'shower-.jpeg', 'shower.jpeg', 'tampak-depan.jpg', 'vip-toilet.jpeg', 'water-heater.jpeg'];
        
        if (in_array($filename, $staticFiles)) {
            return asset('camp/' . $filename);
        }

        if (\Illuminate\Support\Str::startsWith($path, 'storage/')) {
            return asset($path);
        }

        if (
            file_exists(public_path('camp/' . $filename)) ||
            (isset($_SERVER['DOCUMENT_ROOT']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/camp/' . $filename)) ||
            file_exists(base_path('public_html/camp/' . $filename))
        ) {
            return asset('camp/' . $filename);
        }
        return asset('storage/' . $path);
    }
}
