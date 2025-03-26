<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordList extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'words', 'words_count', 'user_id'];

    // Define relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
