<?php

namespace App\Http\Controllers;

use App\Models\WordList;
use Illuminate\Http\Request;

class LearnController extends Controller
{
    public function learn(WordList $wordList, Request $request)
    {
        // Check if the list is public or belongs to the current user
        if (!$wordList->is_public && $wordList->user_id !== auth()->id()) {
            abort(403);
        }

        // Get word pairs and shuffle them for learning variety
        $wordPairs = $wordList->wordPairs->shuffle();

        // Get the direction parameter (default to 'normal')
        $direction = $request->query('direction', 'normal');

        return view('learn.learn', compact('wordList', 'wordPairs', 'direction'));
    }
}
