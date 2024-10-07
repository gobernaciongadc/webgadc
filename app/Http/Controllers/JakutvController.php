<?php


namespace App\Http\Controllers;

use App\Models\Jakutv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JakutvController extends Controller
{
    public function index()
    {

        $transmisiones = Jakutv::all(); // Cambiado a JakuTv
        // $transmisiones = Gobernaciontv::with('categoriaTv')->get();

        return view('jakutv.index', compact('transmisiones')); // Cambiado la vista
    }

    public function create()
    {
        return view('jakutv.create'); // Cambiado la vista
    }

    public function store(Request $request)
    {


        $request->validate([
            'nombre' => 'required',
            // 'horario' => 'required',
            'imagen_tarjeta' => 'required|image|mimes:jpeg,png,jpg,gif', // Validación de imagen
            'descripcion' => 'required',
            'estado' => 'required',
        ]);


        // Manejo de subida de imagen
        if ($request->hasFile('imagen_tarjeta')) {
            $imagen = $request->file('imagen_tarjeta');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $imagen->storeAs('public/uploads', $nombreImagen); // Guarda la imagen en storage/app/public/uploads
        } else {
            $nombreImagen = null;
        }

        Jakutv::create([
            'nombre' => $request->input('nombre'),
            'imagen' => $nombreImagen,
            'descripcion' => $request->input('descripcion'),
            'estado' => $request->input('estado'),
        ]);


        return redirect()->route('jakutv.index') // Cambiado la ruta
            ->with('success', 'Datos creados exitosamente.');
    }


    public function edit($id)
    {
        $gobernaciontv = Jakutv::findOrFail($id); // Busca la transmisión por ID
        return view('jakutv.edit', compact('gobernaciontv')); // Enviando variables a la vista
    }

    public function update(Request $request, $id) // Recibiendo el ID manualmente
    {

        $gobernaciontv = Jakutv::find($id);

        if (!$gobernaciontv) {
            return redirect()->route('jakutv.index')->with('error', 'Categoria no encontrada.');
        }

        $request->validate([
            'nombre' => 'required',
            // 'horario' => 'required',
            'imagen_tarjeta' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Validación de imagen
            'descripcion' => 'required',
            'estado' => 'required'
        ]);


        // Manejo de actualización de imagen
        if ($request->hasFile('imagen_tarjeta')) {
            $imagen = $request->file('imagen_tarjeta');
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
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'estado' => $request->input('estado'),
        ]);

        return redirect()->route('jakutv.index')->with('success', 'Datos actualizados exitosamente.');
    }

    public function destroy(Request $request, $id)
    {
        // Cambiar el estado a "inactivo"
        $jakutv = Jakutv::findOrFail($id); // Busca la transmisión por ID
        $jakutv->update(['estado' => 'off']);

        return redirect()->route('jakutv.index')
            ->with('success', 'El estado ha sido actualizado exitosamente.');
    }
}
