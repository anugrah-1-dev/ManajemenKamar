<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDpTable extends Migration
{
    public function up()
    {
        Schema::create('dp_table', function (Blueprint $table) {
            $table->id();
            // foreign key ke tabel pendaftaran_program_offline (sesuaikan nama tabel jika beda)
            $table->foreignId('pendaftaran_program_offline_id')
                  ->constrained('pendaftaran_program_offline')
                  ->onDelete('cascade');
            $table->string('bukti_dp')->nullable(); // menyimpan path file
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dp_table');
    }
}
