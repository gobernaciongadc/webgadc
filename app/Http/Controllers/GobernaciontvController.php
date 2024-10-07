<?php


namespace App\Http\Controllers;

use App\Models\Gobernaciontv; // Cambiado a Gobernaciontv
use App\Models\Categoriatv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GobernaciontvController extends Controller
{
    public function index()
    {

        $transmisiones = Gobernaciontv::with('categoriaTv')->get();

        return view('gobernaciontv.index', compact('transmisiones')); // Cambiado la vista
    }

    public function create()
    {
        // $categorias = Categoriatv::all();  // O la consulta correspondiente
        $categorias = Categoriatv::where('estado', 'live')->get();
        return view('gobernaciontv.create', compact('categorias')); // Cambiado la vista
    }

    public function store(Request $request)
    {

        $request->validate([
            'programa' => 'required',
            // 'horario' => 'required',
            'imagen_portada' => 'required|image|mimes:jpeg,png,jpg,gif', // Validación de imagen
            'descripcion' => 'required',
            'plataforma' => 'required',
            'estado' => 'required',
            'categoriatv_id' => 'required', // Agregado categoriatv_id
        ]);
        // dd($request->all());


        // Manejo de subida de imagen
        if ($request->hasFile('imagen_portada')) {
            $imagen = $request->file('imagen_portada');
            $nombreImagen = time() . '.' . $imagen->getClientOriginalExtension();
            $imagen->storeAs('public/uploads', $nombreImagen); // Guarda la imagen en storage/app/public/uploads
        } else {
            $nombreImagen = null;
        }


        Gobernaciontv::create([
            'programa' => $request->input('programa'),
            'imagen' => $nombreImagen,
            'descripcion' => $request->input('descripcion'),
            'plataforma' => $request->input('plataforma'),
            'url_youtube' => $request->input('url_youtube'),
            'url_facebook' => $request->input('url_facebook'),
            'estado' => $request->input('estado'),
            'categoriatv_id' => $request->input('categoriatv_id'),
        ]);


        return redirect()->route('gobernaciontv.index') // Cambiado la ruta
            ->with('success', 'Transmisión creada exitosamente.');
    }


    public function edit($id)
    {

        $gobernaciontv = GobernacionTv::findOrFail($id); // Busca la transmisión por ID
        $categorias = Categoriatv::all(); // Consulta de categorías
        return view('gobernaciontv.edit', compact('gobernaciontv', 'categorias')); // Enviando variables a la vista
    }

    public function update(Request $request, $id) // Recibiendo el ID manualmente
    {

        $gobernaciontv = Gobernaciontv::find($id);

        if (!$gobernaciontv) {
            return redirect()->route('gobernaciontv.index')->with('error', 'Transmisión no encontrada.');
        }

        // dd($request->all());
        $request->validate([
            'programa' => 'required',
            // 'horario' => 'required',
            'imagen_portada' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Validación de imagen
            'descripcion' => 'required',
            'plataforma' => 'required',
            'estado' => 'required',
            'categoriatv_id' => 'required', // Agregado categoriatv_id
        ]);


        // Manejo de actualización de imagen
        if ($request->hasFile('imagen_portada')) {
            $imagen = $request->file('imagen_portada');
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
            'programa' => $request->input('programa'),
            'descripcion' => $request->input('descripcion'),
            'plataforma' => $request->input('plataforma'),
            'url_youtube' => $request->input('url_youtube'),
            'url_facebook' => $request->input('url_facebook'),
            'estado' => $request->input('estado'),
            'categoriatv_id' => $request->input('categoriatv_id'),
        ]);

        return redirect()->route('gobernaciontv.index')->with('success', 'Datos actualizados exitosamente.');
    }
    public function destroy($id)
    {
        // Buscar el registro en la base de datos
        $gobernaciontv = Gobernaciontv::find($id);

        // Verificar si el registro existe
        if ($gobernaciontv) {
            // Eliminar el registro
            $gobernaciontv->delete();

            // Redirigir con mensaje de éxito
            return redirect()->route('gobernaciontv.index')
                ->with('success', 'Datos eliminados exitosamente.');
        } else {
            // Si no se encuentra el registro, redirigir con mensaje de error
            return redirect()->route('gestionjakutv.index')
                ->with('error', 'Registro no encontrado.');
        }
    }
}
