<?php

namespace App\Http\Controllers;

use App\Models\jugadores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class JugadoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jugadores = jugadores::where('estado',1)->get();
        return response()->json($jugadores, 200);

        //esto no se usa
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData=$request->validate([
            'nombre'=>'required|string|max:255',
            'apellido'=>'required|string|max:255',
            'cedula'=>'required|string|max:255',
            'telefono'=>'required|string|max:255',
            'direccion'=>'required|string|max:255',
            'foto' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        //imagen
        $img = $request->file('foto');
        $valiData['foto'] =  time().'.'.$img->getClientOriginalExtension();


        $jugadores=jugadores::create([
            'nombre'=>$validateData['nombre'],
            'apellido'=>$validateData['apellido'],
            'cedula'=>$validateData['cedula'],
            'telefono'=>$validateData['telefono'],
            'direccion'=>$validateData['direccion'],
            'foto'=>$valiData['foto'],
            'estado'=>1,
        ]);

        $request->file('foto')->storeAs("public/foto/jugadores/{$jugadores->id}", $valiData['foto']);

        return response()->json(['message'=>'Jugador registrado'],200);
    }

    /**
     * Display the specified resource.
     */
   

    public function show($id)
    {
        $jugadores=jugadores::find($id);
        if (is_null($jugadores)) {
            return response()->json(['message' => 'jugador no encontrado'], 404);
        }
        return response()->json($jugadores);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(jugadores $jugadores)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $jugadores = jugadores::find($id);
        if (is_null($jugadores)) {
            return response()->json(['message' => 'jugador no encontrado.'], 404);
        }
        $validateData = $request->validate([
            'nombre'=>'required|string|max:255',
            'apellido'=>'required|string|max:255',
            'cedula'=>'required|string|max:255',
            'telefono'=>'required|string|max:255',
            'direccion'=>'required|string|max:255'
            
        ]);
        $jugadores->nombre = $validateData['nombre'];
        $jugadores->apellido = $validateData['apellido'];
        $jugadores->cedula = $validateData['cedula'];
        $jugadores->telefono = $validateData['telefono'];
        $jugadores->direccion = $validateData['direccion'];
        $jugadores->save();
        return response()->json(['message' => 'jugador actualizado'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
  

    public function destroy($id)
    {
        $jugadores=jugadores::find($id);
        if (is_null($jugadores)) {
            return response()->json(['message' => 'jugador no encontrado'], 404);
        }
        $jugadores->estado=0;
        $jugadores->save();
        return response()->json(['message'=>'jugador eliminado']);
    }


    public function editarfoto(Request $request, $id ){

        $jugadores = jugadores::find($id);
        if (is_null($jugadores)) {
            return response()->json(['message' => 'Foto no encontrada.'], 404);
        }
        $validateData = $request->validate([
            'foto' => 'required|mimes:jpeg,bmp,png',
        ]);
        $img=$request->file('foto');
        $validateData['foto'] = time().'.'.$img->getClientOriginalExtension();
        $request->file('foto')->storeAs("public/foto/jugadores/{$jugadores->id}", $validateData['foto']);
        $jugadores->foto=$validateData['foto'];
        $jugadores->save();
        return response()->json(['message' => 'Foto del jugador actualizada'], 201);
    }

}
