<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WordList;

class WordListController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wordLists = WordList::where('user_id', auth()->id())->get();

        return view('lists', compact('wordLists'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('createlist');
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'words' => 'required|array',
            'words.*.woord' => 'required|string',
            'words.*.vertaling' => 'required|string',
            'is_public' => 'required|boolean',
        ]);

        $wordsJson = json_encode($request->input('words'));

        WordList::create([
            'title' => $request->input('title'),
            'author' => auth()->user()->username,
            'words' => $wordsJson,
            'words_count' => count($request->input('words')),
            'user_id' => auth()->id(),
            'is_public' => $request->input('is_public'),
        ]);

        return redirect()->route('lists.index')->with('Word list created');
    }
}
