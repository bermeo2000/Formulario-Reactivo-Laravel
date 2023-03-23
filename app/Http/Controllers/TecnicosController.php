<?php

namespace App\Http\Controllers;

use App\Models\tecnicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class TecnicosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tecnicos = tecnicos::where('estado',1)->get();
        return response()->json($tecnicos, 200);

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


        $tecnicos=tecnicos::create([
            'nombre'=>$validateData['nombre'],
            'apellido'=>$validateData['apellido'],
            'cedula'=>$validateData['cedula'],
            'telefono'=>$validateData['telefono'],
            'direccion'=>$validateData['direccion'],
            'foto'=>$valiData['foto'],
            'estado'=>1,
        ]);

        $request->file('foto')->storeAs("public/foto/tecnicos/{$tecnicos->id}", $valiData['foto']);

        return response()->json(['message'=>'tecnico registrado'],200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tecnicos=tecnicos::find($id);
        if (is_null($tecnicos)) {
            return response()->json(['message' => 'Tecnico no encontrado'], 404);
        }
        return response()->json($tecnicos);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(tecnicos $tecnicos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $tecnicos = tecnicos::find($id);
        if (is_null($tecnicos)) {
            return response()->json(['message' => 'tecnico no encontrado.'], 404);
        }
        $validateData = $request->validate([
            'nombre'=>'required|string|max:255',
            'apellido'=>'required|string|max:255',
            'cedula'=>'required|string|max:255',
            'telefono'=>'required|string|max:255',
            'direccion'=>'required|string|max:255'
            
        ]);
        $tecnicos->nombre = $validateData['nombre'];
        $tecnicos->apellido = $validateData['apellido'];
        $tecnicos->cedula = $validateData['cedula'];
        $tecnicos->telefono = $validateData['telefono'];
        $tecnicos->direccion = $validateData['direccion'];
        $tecnicos->save();
        return response()->json(['message' => 'Tecnico actualizado'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tecnicos=tecnicos::find($id);
        if (is_null($tecnicos)) {
            return response()->json(['message' => 'tecnico no encontrado'], 404);
        }
        $tecnicos->estado=0;
        $tecnicos->save();
        return response()->json(['message'=>'tecnico eliminado']);
    }

    public function editarfotoTecnico(Request $request, $id ){

        $tecnicos = tecnicos::find($id);
        if (is_null($tecnicos)) {
            return response()->json(['message' => 'Foto no encontrada.'], 404);
        }
        $validateData = $request->validate([
            'foto' => 'required|mimes:jpeg,bmp,png',
        ]);
        $img=$request->file('foto');
        $validateData['foto'] = time().'.'.$img->getClientOriginalExtension();
        $request->file('foto')->storeAs("public/foto/tecnicos/{$tecnicos->id}", $validateData['foto']);
        $tecnicos->foto=$validateData['foto'];
        $tecnicos->save();
        return response()->json(['message' => 'Foto del tecnicos actualizada'], 201);
    }
}
