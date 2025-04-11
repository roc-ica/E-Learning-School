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
            'is_public' => 'boolean',
        ]);

        // Create the word list
        $wordList = WordList::create([
            'title' => $request->input('title'),
            'author' => auth()->user()->username,
            'words_count' => count($request->input('words')),
            'user_id' => auth()->id(),
            'is_public' => $request->input('is_public', false),
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

    public function edit(WordList $wordList)
    {
        // Ensure the user can only edit their own lists
        if ($wordList->user_id !== auth()->id()) {
            abort(403);
        }

        $wordPairs = $wordList->wordPairs;

        return view('editlist', compact('wordList', 'wordPairs'));
    }

    public function update(Request $request, WordList $wordList)
    {
        // Ensure the user can only update their own lists
        if ($wordList->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'words' => 'required|array',
            'words.*.woord' => 'required|string',
            'words.*.vertaling' => 'required|string',
            'is_public' => 'boolean',
        ]);

        // Update the word list
        $wordList->update([
            'title' => $request->input('title'),
            'words_count' => count($request->input('words')),
            'is_public' => $request->input('is_public', false),
        ]);

        // Delete existing word pairs
        $wordList->wordPairs()->delete();

        // Create new word pairs
        foreach ($request->input('words') as $wordData) {
            $wordList->wordPairs()->create([
                'original_word' => $wordData['woord'],
                'translated_word' => $wordData['vertaling'],
            ]);
        }

        return redirect()->route('lists.index')->with('success', 'Word list updated successfully');
    }

    public function destroy(WordList $wordList)
    {
        // Ensure the user can only delete their own lists
        if ($wordList->user_id !== auth()->id()) {
            abort(403);
        }

        // Delete the word list (word pairs will be deleted via foreign key cascade)
        $wordList->delete();

        return redirect()->route('lists.index')->with('success', 'Word list removed successfully');
    }
}
