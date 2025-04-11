<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WordList;

class WordListController extends Controller
{
    public function index()
    {
        $wordLists = WordList::where('user_id', auth()->id())
            ->withCount('wordPairs')
            ->get();

        return view('lists', compact('wordLists'));
    }

    public function create()
    {
        return view('createlist');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'words' => 'required|array',
            'words.*.woord' => 'required|string',
            'words.*.vertaling' => 'required|string',
            'is_public' => 'required|boolean',
        ]);

        // Create the word list
        $wordList = WordList::create([
            'title' => $request->input('title'),
            'author' => auth()->user()->username,
            'words_count' => count($request->input('words')),
            'user_id' => auth()->id(),
            'is_public' => $request->input('is_public'),
        ]);

        // Store each word pair in the related table
        foreach ($request->input('words') as $wordData) {
            $wordList->wordPairs()->create([
                'original_word' => $wordData['woord'],
                'translated_word' => $wordData['vertaling'],
            ]);
        }

        return redirect()->route('lists.index')->with('success', 'Word list created');
    }
}
