<?php

namespace App\Http\Controllers;

use App\Models\Interestv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InterestvController extends Controller
{
    public function index()
    {
        $transmisiones = Interestv::all(); // Cambiado a JakuTv
        // $transmisiones = Gobernaciontv::with('categoriaTv')->get();
        return view('interestv.index', compact('transmisiones')); // Cambiado la vista
    }

    public function create()
    {
        return view('interestv.create'); // Cambiado la vista
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
        Interestv::create([
            'imagen' => $nombreImagen,
            'descripcion' => $request->input('descripcion'),
            'estado' => $request->input('estado'),
        ]);

        return redirect()->route('interestv.index')
            ->with('success', 'Datos creados exitosamente.');
    }


    public function edit($id)
    {
        $gobernaciontv = Interestv::findOrFail($id); // Busca la transmisión por ID
        return view('interestv.edit', compact('gobernaciontv')); // Enviando variables a la vista
    }

    public function update(Request $request, $id)
    {
        $gobernaciontv = Interestv::find($id);

        if (!$gobernaciontv) {
            return redirect()->route('interestv.index')->with('error', 'Interes no encontrado');
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
            'descripcion' => $request->input('descripcion'),
            'estado' => $request->input('estado')
        ]);

        return redirect()->route('interestv.index')
            ->with('success', 'Datos actualizados exitosamente.');
    }

    public function destroy(Request $request, $id)
    {
        // Cambiar el estado a "inactivo"
        $interestv = Interestv::findOrFail($id); // Busca la transmisión por ID
        $interestv->update(['estado' => 'off']);

        return redirect()->route('interestv.index')
            ->with('success', 'El estado ha sido actualizado exitosamente.');
    }
}
