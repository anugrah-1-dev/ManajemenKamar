<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('program_offline', function (Blueprint $table) {
            $table->dropSoftDeletes(); // Ini akan menghapus kolom deleted_at
        });
    }

    public function down()
    {
        Schema::table('program_offline', function (Blueprint $table) {
            $table->softDeletes(); // Bisa dikembalikan kalau dibutuhkan
        });
    }
};
