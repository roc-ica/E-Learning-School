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

        return view('lists.lists', compact('wordLists'));
    }

    public function create()
    {
        return view('lists.createlist');
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

    public function view(WordList $wordList)
    {
        // Check if the list is public or belongs to the current user
        if (!$wordList->is_public && $wordList->user_id !== auth()->id()) {
            abort(403);
        }

        $wordPairs = $wordList->wordPairs;

        return view('lists.view', compact('wordList', 'wordPairs'));
    }

    public function edit(WordList $wordList)
    {
        if ($wordList->user_id !== auth()->id()) {
            abort(403);
        }

        $wordPairs = $wordList->wordPairs;

        return view('lists.editlist', compact('wordList', 'wordPairs'));
    }

    public function update(Request $request, WordList $wordList)
    {
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

        $wordList->update([
            'title' => $request->input('title'),
            'words_count' => count($request->input('words')),
            'is_public' => $request->input('is_public', false),
        ]);

        $wordList->wordPairs()->delete();

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
        if ($wordList->user_id !== auth()->id()) {
            abort(403);
        }

        $wordList->delete();

        return redirect()->route('lists.index')->with('success', 'Word list removed successfully');
    }

    public function publicLists()
    {
        $publicLists = WordList::where('is_public', 1)
            ->withCount('wordPairs')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('lists.public', compact('publicLists'));
    }
}
