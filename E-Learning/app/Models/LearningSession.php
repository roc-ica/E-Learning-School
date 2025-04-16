<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LearningSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'word_list_id',
        'score',
        'total_words'
    ];

    /**
     * Get the user that owns the learning session.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the word list for this session.
     */
    public function wordList(): BelongsTo
    {
        return $this->belongsTo(WordList::class);
    }

    /**
     * Calculate percentage score
     */
    public function getPercentageAttribute(): int
    {
        return round(($this->score / $this->total_words) * 100);
    }
}
