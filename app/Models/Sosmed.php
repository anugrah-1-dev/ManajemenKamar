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
        if (
            file_exists(public_path('asset/img/' . $filename)) ||
            (isset($_SERVER['DOCUMENT_ROOT']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/asset/img/' . $filename)) ||
            file_exists(base_path('public_html/asset/img/' . $filename))
        ) {
            return asset('asset/img/' . $filename);
        }

        return asset('storage/' . $path);
    }
}
