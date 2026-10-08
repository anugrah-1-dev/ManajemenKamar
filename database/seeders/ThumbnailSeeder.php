<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class ThumbnailSeeder extends Seeder
{
    public function run(): void
    {
        $source = public_path('camp');
        $destination = storage_path('app/public/upload/camp');

        // pastikan folder tujuan ada
        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        // ambil semua file dari public/camp
        $files = File::files($source);

        $campIds = [1, 2, 3];

        foreach ($campIds as $campId) {
            $shuffled = $files;
            shuffle($shuffled);

            // ambil jumlah random 4 - semua
            $take = rand(4, count($shuffled));
            $selected = array_slice($shuffled, 0, $take);

            foreach ($selected as $file) {
                $filename = $file->getFilename();
                $targetPath = $destination . '/' . $filename;

                if (!File::exists($targetPath)) {
                    File::copy($file->getPathname(), $targetPath);
                }

                DB::table('thumbnails')->insert([
                    'program_camp_id' => $campId,
                    'image' => 'storage/upload/camp/' . $filename,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
