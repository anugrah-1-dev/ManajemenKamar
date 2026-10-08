<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Hapus kolom lama (jika enum ingin diubah)
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['gender', 'kategori']);
        });

        // Tambahkan ulang kolom dengan enum baru
        Schema::table('rooms', function (Blueprint $table) {
            $table->enum('gender', ['putra', 'putri'])->after('nomor_kamar');
            $table->enum('kategori', ['vvip', 'vip', 'barack'])->after('gender');
        });
    }

    public function down()
    {
        // Rollback ke enum lowercase
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['gender', 'kategori']);
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->enum('gender', ['putra', 'putri'])->after('nomor_kamar');
            $table->enum('kategori', ['vvip', 'vip', 'barack'])->after('gender');
        });
    }
};
