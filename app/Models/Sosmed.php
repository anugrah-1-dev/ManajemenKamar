<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sosmed extends Model
{
    protected $table = 'sosmed';

    protected $fillable = [
        'nama',
        'url',
        'image_path',
    ];

    public function getYoutubeIdAttribute()
    {
        preg_match('/(?:v=|\/embed\/|\.be\/)([^&\n]+)/', $this->url, $matches);
        return $matches[1] ?? null;
    }

    public function getThumbnailUrlAttribute()
    {
        if (strtolower($this->platform) === 'youtube') {
            return 'https://img.youtube.com/vi/' . $this->youtube_id . '/hqdefault.jpg';
        }

        return asset('storage/' . $this->image_path);
    }
}
