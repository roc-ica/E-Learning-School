<?php

namespace App\Http\Controllers;

use App\Models\WordList;
use App\Models\LearningSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearnController extends Controller
{
    public function learn(WordList $wordList, Request $request)
    {
        $wordPairs = $wordList->wordPairs;
        $direction = $request->query('direction', 'normal');

        return view('learn.learn', compact('wordList', 'wordPairs', 'direction'));
    }

    public function saveScore(WordList $wordList, Request $request)
    {
        $validated = $request->validate([
            'score' => 'required|integer|min:0',
            'total_words' => 'required|integer|min:1',
            'direction' => 'required|in:normal,reversed',
        ]);

        $learningSession = new LearningSession([
            'user_id' => Auth::id(),
            'word_list_id' => $wordList->id,
            'score' => $validated['score'],
            'total_words' => $validated['total_words'],
            'direction' => $validated['direction'],
        ]);

        $learningSession->save();

        return redirect()->route('lists.history', $wordList)->with('success', 'Score saved successfully!');
    }

    public function history(WordList $wordList)
    {
        $sessions = $wordList->learningSessions()
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('learn.history', compact('wordList', 'sessions'));
    }
}
