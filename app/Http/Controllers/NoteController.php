<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddNoteRequest;
use App\Http\Requests\EditNoteRequest;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $all = $request->all();
        $oNotes = Note::search($all)->orderBy('created_at', 'desc')->paginate(3);
        return response()->json($oNotes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AddNoteRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddNoteRequest $request)
    {
        $oNote = new Note();
        $oNote->author = $request->input('author');
        $oNote->note = $request->input('note');
        $oNote->save();

        return response()->json(['status' => 1, 'message' => 'Note Added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(EditNoteRequest $request, $id)
    {
        $oNote = Note::find($id);
        $oNote->author = $request->input('author');
        $oNote->note = $request->input('note');
        $oNote->save();

        return response()->json(['status' => 1, 'message' => 'Note Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $oNote = Note::find($id);
        $oNote->delete();

        return response()->json(['status' => 1, 'message' => 'Note Deleted']);
    }
}
