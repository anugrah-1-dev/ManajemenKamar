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
        if (isset($this->platform) && strtolower($this->platform) === 'youtube') {
            return 'https://img.youtube.com/vi/' . $this->youtube_id . '/hqdefault.jpg';
        }

        $path = $this->image_path;
        if (\Illuminate\Support\Str::startsWith($path, 'storage/')) {
            return asset($path);
        }
        $filename = basename($path);
        if (file_exists(public_path('camp/' . $filename))) {
            return asset('camp/' . $filename);
        }
        if (file_exists(public_path('asset/img/' . $filename))) {
            return asset('asset/img/' . $filename);
        }

        return asset('storage/' . $path);
    }
}
