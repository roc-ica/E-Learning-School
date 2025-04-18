<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('word_lists', function (Blueprint $table) {
            $table->json('words')->nullable()->after('author'); // Add the words column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('word_lists', function (Blueprint $table) {
            $table->dropColumn('words');
        });
    }
};
