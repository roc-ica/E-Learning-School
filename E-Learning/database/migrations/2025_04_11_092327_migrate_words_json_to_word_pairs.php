<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $wordLists = DB::table('word_lists')->get();

        foreach ($wordLists as $wordList) {
            $words = json_decode($wordList->words, true);

            if (is_array($words)) {
                foreach ($words as $word) {
                    DB::table('word_pairs')->insert([
                        'word_list_id' => $wordList->id,
                        'original_word' => $word['woord'],
                        'translated_word' => $word['vertaling'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    public function down()
    {
        DB::table('word_pairs')->truncate();
    }
};
