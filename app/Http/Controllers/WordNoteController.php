<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class WordNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::latest()->where('pubpriv', true)->paginate(10);
        return Inertia::render('Notes/NoteList', ['notes' => $notes]);
    }

    public function myIndex()
    {
        $notes = Note::latest()->where('user_id', auth()->user()->id)->paginate(10);
        return Inertia::render('Notes/MyNoteList', ['notes' => $notes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $note = Note::create(['title' => $request->title, 'user_id' => auth()->user()->id, 'pubpriv' => $request->pubpriv]);
        // dd($note);
        // return Redirect::route('notes.index');

        return $note->id;

    }

    public function wordStore(Request $request)
    {
        // dd($request);

        Word::create(['language' => $request->language, 'mean' => $request->mean, 'note_id' => $request->note_id]);

        return Redirect::route('notes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $note = Note::find($id);

        return Inertia::render('Notes/ShowNote', ['note' => $note]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
