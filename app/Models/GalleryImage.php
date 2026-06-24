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
        
        if (\Illuminate\Support\Str::startsWith($path, 'storage/')) {
            return asset($path);
        }
        $filename = basename($path);
        if (file_exists(public_path('camp/' . $filename))) {
            return asset('camp/' . $filename);
        }
        return asset('storage/' . $path);
    }
}
