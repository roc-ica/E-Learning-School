<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('word_pairs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('word_list_id')->constrained()->onDelete('cascade');
            $table->string('original_word');
            $table->string('translated_word');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('word_pairs');
    }
};
