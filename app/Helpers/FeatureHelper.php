<?php

namespace App\Helpers;

class FeatureHelper
{
    public static function getFeatureIcon(string $fitur): string
    {
        $fitur = strtolower($fitur);

        $icons = [
            // list tambahan dari kamu
            'kamar'        => '🛏️',
            'wifi'         => '📶',
            'makan'        => '🍽️',
            'laundry'      => '🧺',
            'ac'           => '❄️',
            'parkir'       => '🅿️',

            // list fasilitas program
            'sesi'         => '✅',
            'kelas'        => '✅',
            'modul'        => '📘',
            'buku'         => '📘',
            'merchandise'  => '🎁',
            'sertifikat'   => '🎓',
            'enterpreneur' => '💼',
            'psychotraining' => '🧠',
            'multimedia'   => '🖥️',
            'drink'        => '🍹',
            'welcome party' => '🎉',
            'farewell party' => '🎉',
            'penjemputan'  => '🚌',
            'stasiun'      => '🚉',
            'terminal'     => '🚍',
        ];

        foreach ($icons as $keyword => $icon) {
            if (str_contains($fitur, $keyword)) {
                return $icon;
            }
        }

        return '✅'; // default kalau tidak ada yang match
    }
}
