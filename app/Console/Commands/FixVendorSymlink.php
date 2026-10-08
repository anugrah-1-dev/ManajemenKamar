<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixVendorSymlink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:vendor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fixes the public/vendor assets by copying them into the root vendor directory for shared hosting';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai penyalinan folder public/vendor ke direktori utama (kamar/vendor)...');

        $source = base_path('public/vendor');
        $destination = base_path('vendor');

        if (!File::exists($source)) {
            $this->error("Folder sumber '{$source}' tidak ditemukan! Pastikan sudah menjalankan php artisan adminlte:install.");
            return 1;
        }

        if (!File::exists($destination)) {
            $this->info("Folder 'vendor' utama belum ada. Membuat folder...");
            File::makeDirectory($destination, 0755, true);
        }

        $directories = File::directories($source);
        $filesCopied = 0;

        foreach ($directories as $dir) {
            $dirName = basename($dir);
            $destDir = $destination . '/' . $dirName;
            
            $this->line("Menyalin {$dirName}...");
            File::copyDirectory($dir, $destDir);
            $filesCopied++;
        }

        $this->info("Berhasil menyalin {$filesCopied} modul ke folder vendor utama!");
        $this->info('Semua error 404 (Bootstrap, jQuery, dll) sudah beres!');
        
        return 0;
    }
}
