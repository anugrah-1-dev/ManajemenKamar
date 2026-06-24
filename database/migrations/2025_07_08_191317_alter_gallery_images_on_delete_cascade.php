<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Buat tabel sementara dengan foreign key onDelete('restrict')
        Schema::create('gallery_images_temp', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gallery_id');
            $table->string('image_path');
            $table->timestamps();

            $table->foreign('gallery_id')
                ->references('id')
                ->on('galleries')
                ->onDelete('restrict');

        });

        // Salin data dari tabel lama
        DB::statement('INSERT INTO gallery_images_temp (id, gallery_id, image_path, created_at, updated_at)
                       SELECT id, gallery_id, image_path, created_at, updated_at FROM gallery_images');

        // Hapus tabel lama dan ganti nama
        Schema::drop('gallery_images');
        Schema::rename('gallery_images_temp', 'gallery_images');
    }

    public function down()
    {
        // Buat kembali versi lama dengan onDelete('cascade')
        Schema::create('gallery_images_old', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gallery_id');
            $table->string('image_path');
            $table->timestamps();

            $table->foreign('gallery_id')
                ->references('id')
                ->on('galleries')
                ->onDelete('cascade');
        });

        DB::statement('INSERT INTO gallery_images_old (id, gallery_id, image_path, created_at, updated_at)
                       SELECT id, gallery_id, image_path, created_at, updated_at FROM gallery_images');

        Schema::drop('gallery_images');
        Schema::rename('gallery_images_old', 'gallery_images');
    }
};
