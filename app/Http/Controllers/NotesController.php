<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;
use Auth;

class NotesController extends Controller
{
    public function __construct()
    {
        // Se necesita esta autentificado para llevar a cabo acciones
        // de CRUD sobre las notas
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$notes = Note::all();
        $notes = Note::orderBy('order', 'ASC')->get();
        return response()->json($notes);
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
        $note = new Note();
        $note->user_id = Auth::user()->id;
        $note->title = "New note";
        $note->body = "Write something here.";
        $note->order = 0;
        $note->bgcolor = "note-color-darkblue";
        $note->save();
        return response()->json($note);
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
    public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $note_id = $id;
        $note = Note::find($note_id);
        if ($user_id != $note->user_id) {
            return 'This note does not belong to you!';
        }
        
        $note->title = $request['data']['title'];
        $note->body = $request['data']['body'];
        $note->order = $request['data']['order'];
        $note->bgcolor = $request['data']['bgcolor'];
        $note->save();
        return response()->json($note);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = Auth::user()->id;
        $note_id = $id;
        $note = Note::find($note_id);
        if ($user_id != $note->user_id) {
            return 'This note does not belong to you!';
        }

        $note->delete();
        // if $note->delete()
        // return response()->json($note, 200);
        // else
        // return response()->json($note, 400);

        return response()->json($note);
    }
}