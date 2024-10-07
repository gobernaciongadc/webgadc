<?php

namespace App\Http\Controllers;

use App\Models\Modaltv;
use App\Models\Radiotv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModaltvController extends Controller
{
    public function index()
    {
        $transmisiones = Modaltv::all(); // Cambiado a JakuTv
        // $transmisiones = Gobernaciontv::with('categoriaTv')->get();
        return view('modaltv.index', compact('transmisiones')); // Cambiado la vista
    }

    public function create()
    {
        return view('modaltv.create'); // Cambiado la vista
    }

    public function store(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif', // Validación de imagen
            'descripcion' => 'required',
        ]);

        // Manejo de subida de imagen
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $imagen->storeAs('public/uploads', $nombreImagen); // Guarda la imagen en storage/app/public/uploads
        } else {
            $nombreImagen = null;
        }

        // Crear un nuevo registro con los datos
        Modaltv::create([
            'url_documento' => $request->input('url_documento'),
            'imagen' => $nombreImagen,
            'descripcion' => $request->input('descripcion'),
            'estado' => $request->input('estado'),
        ]);

        return redirect()->route('modaltv.index')
            ->with('success', 'Datos creados exitosamente.');
    }


    public function edit($id)
    {
        $gobernaciontv = Modaltv::findOrFail($id); // Busca la transmisión por ID
        return view('modaltv.edit', compact('gobernaciontv')); // Enviando variables a la vista
    }

    public function update(Request $request, $id)
    {
        $gobernaciontv = Modaltv::find($id);

        if (!$gobernaciontv) {
            return redirect()->route('modaltv.index')->with('error', 'Modal no encontrado');
        }

        // dd($request->all());
        $request->validate([
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'descripcion' => 'required',
            'estado' => 'required'
        ]);

        // Manejo de actualización de imagen
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $imagen->storeAs('public/uploads', $nombreImagen);

            // Eliminar la imagen anterior si es necesario
            if ($gobernaciontv->imagen) {
                Storage::delete('public/uploads/' . $gobernaciontv->imagen);
            }

            // Actualizar con la nueva imagen
            $gobernaciontv->imagen = $nombreImagen;
        }

        // Actualizar otros campos
        $gobernaciontv->update([
            'url_documento' => $request->input('url_documento'),
            'descripcion' => $request->input('descripcion'),
            'estado' => $request->input('estado')
        ]);

        return redirect()->route('modaltv.index')
            ->with('success', 'Datos actualizados exitosamente.');
    }

    public function destroy(Request $request, $id)
    {
        // Cambiar el estado a "inactivo"
        $modaltv = Modaltv::findOrFail($id); // Busca la transmisión por ID
        $modaltv->update(['estado' => 'off']);

        return redirect()->route('modaltv.index')
            ->with('success', 'El estado ha sido actualizado exitosamente.');
    }
}
