<?php

namespace App\Http\Controllers;

use App\Models\presidentes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class PresidentesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presidentes = presidentes::where('estado',1)->get();
        return response()->json($presidentes, 200);
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
        ]);
      
        $presidentes=presidentes::create([
            'nombre'=>$validateData['nombre'],
            'apellido'=>$validateData['apellido'],
            'cedula'=>$validateData['cedula'],
            'telefono'=>$validateData['telefono'],
            'direccion'=>$validateData['direccion'],
            'estado'=>1,
        ]);

        return response()->json(['message'=>'presidentes registrado'],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(presidentes $presidentes)
    {
        $presidentes=presidentes::find($id);
        if (is_null($presidentes)) {
            return response()->json(['message' => 'presidentes no encontrado'], 404);
        }
        return response()->json($presidentes);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(presidentes $presidentes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $presidentes = presidentes::find($id);
        if (is_null($presidentes)) {
            return response()->json(['message' => 'presidentes no encontrado.'], 404);
        }
        $validateData = $request->validate([
            'nombre'=>'required|string|max:255',
            'apellido'=>'required|string|max:255',
            'cedula'=>'required|string|max:255',
            'telefono'=>'required|string|max:255',
            'direccion'=>'required|string|max:255'
            
        ]);
        $presidentes->nombre = $validateData['nombre'];
        $presidentes->apellido = $validateData['apellido'];
        $presidentes->cedula = $validateData['cedula'];
        $presidentes->telefono = $validateData['telefono'];
        $presidentes->direccion = $validateData['direccion'];
        $presidentes->save();
        return response()->json(['message' => 'presidentes actualizado'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $presidentes=presidentes::find($id);
        if (is_null($presidentes)) {
            return response()->json(['message' => 'presidentes no encontrado'], 404);
        }
        $presidentes->estado=0;
        $presidentes->save();
        return response()->json(['message'=>'presidentes eliminado']);
    }

}
