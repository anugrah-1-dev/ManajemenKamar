<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'status',
    ];

    // Relasi: satu gallery memiliki banyak gambar
    public function images()
    {
        return $this->hasMany(GalleryImage::class);
    }
}
