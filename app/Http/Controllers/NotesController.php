<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\NoteUpdateRequest;
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
        // Todas las notas (sin ordenar)
        // $notes = Note::all();

        // Obtenemos las notas ordenadas
        $notes = Note::orderBy('order', 'ASC')->get();

        // Devolvemos el json con las notas y codigo 200
        return response()->json($notes, 200);
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
        // Creamos el modelo para la nueva nota
        $note = new Note();

        // e insertamos los datos por defecto.
        $note->user_id = Auth::user()->id;
        $note->title = "New note";
        $note->body = "Write something here.";
        $note->order = 0;
        $note->bgcolor = "note-color-darkblue";

        // Si la nota no se pudo insertar en la DB ...
        if (!$note->save()) {
            // Devolvemos un error
            return response()->json(['The note cannot be created.'], 500);
        }

        // Nota creada correctamente
        return response()->json($note, 201);
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
    public function update(NoteUpdateRequest $request, $note_id)
    {
        // Este metodo arrojara una excepcion si los campos requeridos
        // por NoteUpdateRequest no satisfacen las reglas definidas.
        // Cuando el metodo llega a ejecutarse quiere decir que todos
        // los criterios fueron cumplidos.
        $user_id = Auth::user()->id;
        $note = Note::where(['id' => $note_id, 'user_id' => $user_id])->first();
        
        // Si no se ha encontrado ninguna nota ...
        if ($note === null) {
            return response()->json(['Note not found'], 500);
        }

        // Asignacion de valores
        $note->title = $request['data']['title'];
        $note->body = $request['data']['body'];
        $note->order = $request['data']['order'];
        $note->bgcolor = $request['data']['bgcolor'];

        // Si falla algo al actualizar ...
        if (!$note->save()) {
            return response()->json(['The note cannot be updated.'], 500);
        }
        
        // Actualizacion correcta
        return response()->json($note, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($note_id)
    {
        $user_id = Auth::user()->id;
        $note = Note::where(['id' => $note_id, 'user_id' => $user_id])->first();
        
        // Si no se ha encontrado ninguna nota ...
        if ($note === null) {
            return response()->json(['Note not found'], 500);
        }

        // Si se produce algun error al borrar ...
        if (!$note->delete()) {
            return response()->json(['The note cannot be deleted.'], 500);
        }

        // Borrado con exito
        return response()->json([], 204);
    }
}