<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WordList; // Ensure this matches your actual model name

class WordListController extends Controller
{
    public function index()
    {
        // Fetch all word lists from the database
        $wordLists = WordList::all();

        // Pass the word lists to the view
        return view('lists', compact('wordLists'));
    }

    public function create()
    {
        return view('createlist');
    }

    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'words_count' => 'required|integer',
        ]);

        // Create a new word list
        WordList::create([
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'words_count' => $request->input('words_count'),
        ]);

        // Redirect to the lists index
        return redirect()->route('lists.index')->with('success', 'Word list created successfully!');
    }
}
