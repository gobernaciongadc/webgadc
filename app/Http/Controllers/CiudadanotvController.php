<?php

namespace App\Http\Controllers;

use App\Models\Ciudadanotv;
use App\Models\Modaltv;
use App\Models\Radiotv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CiudadanotvController extends Controller
{
    public function index()
    {
        $transmisiones = Ciudadanotv::all(); // Cambiado a JakuTv
        // $transmisiones = Gobernaciontv::with('categoriaTv')->get();
        return view('ciudadanotv.index', compact('transmisiones')); // Cambiado la vista
    }

    public function create()
    {
        return view('ciudadanotv.create'); // Cambiado la vista
    }

    public function store(Request $request)
    {
        $request->validate([
            'url_documento' => 'required', // Validación de imagen
            'imagen_ciudadano' => 'required', // icono
            'descripcion' => 'required',
            'estado' => 'required',
        ]);

        // dd($nombreImagen);

        // Crear un nuevo registro con los datos
        Ciudadanotv::create([
            'url_documento' => $request->input('url_documento'),
            'imagen' => $request->input('imagen_ciudadano'),
            'descripcion' => $request->input('descripcion'),
            'estado' => $request->input('estado'),
        ]);

        return redirect()->route('ciudadanotv.index')
            ->with('success', 'Datos creados exitosamente.');
    }

    public function edit($id)
    {
        $gobernaciontv = Ciudadanotv::findOrFail($id); // Busca la transmisión por ID
        return view('ciudadanotv.edit', compact('gobernaciontv')); // Enviando variables a la vista
    }

    public function update(Request $request, $id)
    {
        $gobernaciontv = Ciudadanotv::find($id);

        if (!$gobernaciontv) {
            return redirect()->route('ciudadanotv.index')->with('error', 'Modal no encontrado');
        }

        // dd($request->all());
        $request->validate([
            'url_documento' => 'required',
            'imagen_ciudadano' => 'nullable', // Validación de icono
            'descripcion' => 'required',
            'estado' => 'required'
        ]);

        // Actualizar otros campos
        $gobernaciontv->update([
            'url_documento' => $request->input('url_documento'),
            'imagen' => $request->input('imagen_ciudadano'),
            'descripcion' => $request->input('descripcion'),
            'estado' => $request->input('estado')
        ]);

        return redirect()->route('ciudadanotv.index')
            ->with('success', 'Datos actualizados exitosamente.');
    }

    public function destroy(Request $request, $id)
    {
        // Cambiar el estado a "inactivo"
        $modaltv = Ciudadanotv::findOrFail($id); // Busca la transmisión por ID
        $modaltv->update(['estado' => 'off']);

        return redirect()->route('ciudadanotv.index')
            ->with('success', 'El estado ha sido actualizado exitosamente.');
    }
}
