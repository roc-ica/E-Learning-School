<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordPair extends Model
{
    use HasFactory;

    protected $fillable = ['word_list_id', 'original_word', 'translated_word'];

    public function wordList()
    {
        return $this->belongsTo(WordList::class);
    }
}
