<?php

namespace App\Http\Controllers;

use App\Models\WordList;
use Illuminate\Http\Request;

class LearnController extends Controller
{
    public function learn(WordList $wordList)
    {
        // Check if the list is public or belongs to the current user
        if (!$wordList->is_public && $wordList->user_id !== auth()->id()) {
            abort(403);
        }

        $wordPairs = $wordList->wordPairs;

        return view('learn.learn', compact('wordList', 'wordPairs'));
    }
}
