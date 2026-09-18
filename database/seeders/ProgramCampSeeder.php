<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramCamp;
use Illuminate\Support\Str;

class ProgramCampSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'BIE+ Camp [VVIP]',
                'slug' => Str::slug('Camp VVIP Putra Putri'),
                'kategori' => 'VVIP',
                'stok' => 10,
                // 20
                'harga_perhari' => 250000,
                'harga_satu_minggu' => 1500000,
                'harga_dua_minggu' => 2800000,
                'harga_tiga_minggu' => 4000000,
                'harga_satu_bulan' => 5000000,
                'harga_dua_bulan' => 9000000,
                'harga_tiga_bulan' => 13000000,
                'harga_enam_bulan' => 25000000,
                'harga_satu_tahun' => 45000000,
                'fasilitas' => json_encode([
                    'Pemanas Air',
                    'Wifi',
                    'Pendingin Ruangan',
                    'Tempat Tidur',
                    'Kamar Terpisah Untuk Pria dan Wanita',
                    'Shower',
                    'Area Umum',
                    'Tempat Sampah',
                    'Lemari',
                    'Keset',
                    'Kamera CCTV Untuk Keamanan Anda',
                    'Keamanan 24 Jam',
                ]),

                'thumbnail_id' => null,
            ],

            [
                'nama' => 'BIE+ Camp [VIP]',
                'slug' => Str::slug('Camp VIP Putra'),
                'kategori' => 'VIP',
                'stok' => 134,
                // 268
                'harga_perhari' => 200000,
                'harga_satu_minggu' => 1200000,
                'harga_dua_minggu' => 2200000,
                'harga_tiga_minggu' => 3200000,
                'harga_satu_bulan' => 4000000,
                'harga_dua_bulan' => 7500000,
                'harga_tiga_bulan' => 11000000,
                'harga_enam_bulan' => 21000000,
                'harga_satu_tahun' => 39000000,
                'fasilitas' => json_encode([
                    'Double-Deck Bed',
                    'Pemanas Air',
                    'Wifi',
                    'Pendingin Ruangan',
                    'Kamera CCTV Untuk Keamanan Anda',
                    'Area Ruangan Yang Luas',
                    'Keamanan 24 Jam',
                    'Tempat Tidur',
                    'Kamar Terpisah Untuk Pria dan Wanita',
                    'Shower',
                    'Area Umum',
                    'Tempat Sampah',
                    'Lemari',
                    'Keset',

                ]),

                'thumbnail_id' => null,
            ],
            [
                'nama' => 'BIE+ Camp [Barack]',
                'slug' => Str::slug('Camp Barack Putra Putri'),
                'kategori' => 'Barack',
                'stok' => 2,
                // 12
                'harga_perhari' => 150000,
                'harga_satu_minggu' => 900000,
                'harga_dua_minggu' => 1700000,
                'harga_tiga_minggu' => 2400000,
                'harga_satu_bulan' => 3000000,
                'harga_dua_bulan' => 5800000,
                'harga_tiga_bulan' => 8500000,
                'harga_enam_bulan' => 16000000,
                'harga_satu_tahun' => 30000000,
                'fasilitas' => json_encode([
                    'Double-Deck Bed',
                    'Pemanas Air',
                    'Wifi',
                    'Area Ruangan Yang Luas',
                    'Pendingin Ruangan',
                    'Kamera CCTV Untuk Keamanan Anda',
                    'Keamanan 24 Jam',
                    'Tempat Tidur',
                    'Kamar Terpisah Untuk Pria dan Wanita',
                    'Shower',
                    'Area Umum',
                    'Tempat Sampah',
                    'Lemari',
                    'Keset',

                ]),
                'thumbnail_id' => null,
            ],
        ];

        foreach ($data as $item) {
            ProgramCamp::updateOrInsert(
                ['slug' => $item['slug']], // Unik berdasarkan slug
                array_merge($item, [
                    'updated_at' => now(),
                    'created_at' => now(), // Tidak dipakai kalau data sudah ada
                ])
            );
        }
    }
}
