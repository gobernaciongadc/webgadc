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
            'imagen_ciudadano' => 'required|image|mimes:jpeg,png,jpg,gif', // Validación de imagen
            'descripcion' => 'required',
            'estado' => 'required',
        ]);

        // Manejo de subida de archivos
        if ($request->hasFile('imagen_ciudadano')) {
            $fileImagen = $request->file('imagen_ciudadano');
            $nombreImagen = time() . '.' . $fileImagen->getClientOriginalExtension();
            $fileImagen->storeAs('public/uploads', $nombreImagen); // Guarda el archivo en storage/app/public/uploads
        } else {
            $nombreImagen = null;
        }

        // dd($nombreImagen);

        // Crear un nuevo registro con los datos
        Ciudadanotv::create([
            'url_documento' => $request->input('url_documento'),
            'imagen' => $nombreImagen,
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
            'imagen_ciudadano' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Validación de imagen
            'descripcion' => 'required',
            'estado' => 'required'
        ]);


        // Manejo de actualización de archivo
        if ($request->hasFile('imagen_ciudadano')) {
            $fileImagen = $request->file('imagen_ciudadano');
            $nombreImagen = time() . '.' . $fileImagen->getClientOriginalExtension();
            $fileImagen->storeAs('public/uploads', $nombreImagen);

            // Eliminar el archivo anterior si es necesario
            if ($gobernaciontv->imagen) {
                Storage::delete('public/uploads/' . $gobernaciontv->imagen);
            }

            // Actualizar con el nuevo archivo
            $gobernaciontv->imagen = $nombreImagen;
        }


        // Actualizar otros campos
        $gobernaciontv->update([
            'url_documento' => $request->input('url_documento'),
            'imagen' => $gobernaciontv->imagen,
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
