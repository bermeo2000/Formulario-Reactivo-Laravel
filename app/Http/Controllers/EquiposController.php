<?php

namespace App\Http\Controllers;

use App\Models\equipos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class EquiposController extends Controller
{


    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $equipos = equipos::where('estado',1)->get();
        return response()->json($equipos, 200);

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
     * Guardar  Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData=$request->validate([
            'nombre'=>'required|string|max:255',
            'foto' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        //imagen
        $img = $request->file('foto');
        $valiData['foto'] =  time().'.'.$img->getClientOriginalExtension();


        $equipos=equipos::create([
            'nombre'=>$validateData['nombre'],
            'foto'=>$valiData['foto'],
            'estado'=>1,
        ]);

        $request->file('foto')->storeAs("public/foto/equipos/{$equipos->id}", $valiData['foto']);

        return response()->json(['message'=>'equipos registrado'],200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $equipos=equipos::find($id);
        if (is_null($equipos)) {
            return response()->json(['message' => 'jugador no encontrado'], 404);
        }
        return response()->json($equipos);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(equipos $equipos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $equipos = equipos::find($id);
        if (is_null($equipos)) {
            return response()->json(['message' => 'equipos no encontrado.'], 404);
        }
        $validateData = $request->validate([
            'nombre'=>'required|string|max:255',
            
        ]);
        $equipos->nombre = $validateData['nombre'];
        $equipos->save();
        return response()->json(['message' => 'equipos actualizado'], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $equipos=equipos::find($id);
        if (is_null($equipos)) {
            return response()->json(['message' => 'equipos no encontrado'], 404);
        }
        $equipos->estado=0;
        $equipos->save();
        return response()->json(['message'=>'equipos eliminado']);
    }

    public function editarfotoequipo(Request $request, $id ){

        $equipos = equipos::find($id);
        if (is_null($equipos)) {
            return response()->json(['message' => 'Foto no encontrada.'], 404);
        }
        $validateData = $request->validate([
            'foto' => 'required|mimes:jpeg,bmp,png',
        ]);
        $img=$request->file('foto');
        $validateData['foto'] = time().'.'.$img->getClientOriginalExtension();
        $request->file('foto')->storeAs("public/foto/equipos/{$equipos->id}", $validateData['foto']);
        $equipos->foto=$validateData['foto'];
        $equipos->save();
        return response()->json(['message' => 'Foto del equipos actualizada'], 201);
    }
}

