<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('word_lists', function (Blueprint $table) {
            if (Schema::hasColumn('word_lists', 'words')) {
                $table->dropColumn('words');
            }
        });
    }

    public function down()
    {
        Schema::table('word_lists', function (Blueprint $table) {
            $table->json('words')->nullable();
        });
    }
};
