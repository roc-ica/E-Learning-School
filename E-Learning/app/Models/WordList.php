<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordList extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'words_count', 'user_id', 'is_public'];

    // Define relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Add relationship with WordPair model
    public function wordPairs()
    {
        return $this->hasMany(WordPair::class);
    }

    /**
     * Get the learning sessions for this word list.
     */
    public function learningSessions()
    {
        return $this->hasMany(LearningSession::class);
    }
}
