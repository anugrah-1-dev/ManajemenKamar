<?php

if (!function_exists('getYoutubeVideoId')) {
    function getYoutubeVideoId($url)
    {
        $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/|youtube\.com\/shorts\/)([^"&?/ ]{11})%i';
        preg_match($pattern, $url, $matches);
        return $matches[1] ?? null;
    }
}
