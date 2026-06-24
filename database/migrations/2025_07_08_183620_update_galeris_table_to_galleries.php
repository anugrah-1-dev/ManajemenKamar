<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGalerisTableToGalleries extends Migration
{
    public function up()
    {
        // Rename table dari 'galeris' ke 'galleries'
        Schema::rename('galeris', 'galleries');

        Schema::table('galleries', function (Blueprint $table) {
            $table->text('description')->nullable()->after('title');
            $table->dropColumn('image_path');
        });
    }

    public function down()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('image_path')->after('title');
            $table->dropColumn('description');
        });

        Schema::rename('galleries', 'galeris');
    }
}
