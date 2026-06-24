<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thumbnails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_camp_id');
            $table->string('image'); // path atau URL gambar
            $table->timestamps();

            $table->foreign('program_camp_id')
                ->references('id')
                ->on('program_camp')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thumbnails');
    }
};
