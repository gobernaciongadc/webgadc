<?php


namespace App\Http\Controllers;

use App\Models\Gobernaciontv; // Cambiado a Gobernaciontv
use App\Models\Categoriatv;
use App\Models\Gestionjakutv;
use App\Models\Jakutv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GestionjakutvController extends Controller
{
    public function index()
    {

        // $transmisiones = Gobernaciontv::all(); // Cambiado a Gobernaciontv
        $transmisiones = Gestionjakutv::with('categoriaTv')->get();

        return view('gestionjakutv.index', compact('transmisiones')); // Cambiado la vista
    }

    public function create()
    {
        // $categorias = Categoriatv::all();  // O la consulta correspondiente
        $categorias = Jakutv::where('estado', 'live')->get();
        return view('gestionjakutv.create', compact('categorias')); // Cambiado la vista
    }

    public function store(Request $request)
    {

        // dd($request->all());

        // Validación
        $request->validate([
            'nombre_archivo' => 'required',
            'archivo_tarjeta' => 'required|file|mimes:pdf,xlsx,mp4,doc,docx|max:2048000', // Ajuste de validación (máximo 2 GB en bytes) // Validar archivos y máximo de 2 GB
            'imagen_portada' => 'required|image|mimes:jpeg,png,jpg,gif', // Validación de imagen
            'estado' => 'required',
            'categoriatv_id' => 'required',
        ]);


        // Manejo de subida de archivos
        if ($request->hasFile('archivo_tarjeta')) {
            $file = $request->file('archivo_tarjeta');
            $nombreArchivo = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/uploads', $nombreArchivo); // Guarda el archivo en storage/app/public/uploads
        } else {
            $nombreArchivo = null;
        }

        // Manejo de subida de archivos
        if ($request->hasFile('imagen_portada')) {
            $fileImagen = $request->file('imagen_portada');
            $nombreImagen = time() . '.' . $fileImagen->getClientOriginalExtension();
            $fileImagen->storeAs('public/uploads', $nombreImagen); // Guarda el archivo en storage/app/public/uploads
        } else {
            $nombreImagen = null;
        }

        // Creación del registro
        Gestionjakutv::create([
            'nombre' => $request->input('nombre_archivo'),
            'archivo' => $nombreArchivo,
            'imagen_portada' => $nombreImagen,
            'estado' => $request->input('estado'),
            'categoriatv_id' => $request->input('categoriatv_id'),
        ]);

        return redirect()->route('gestionjakutv.index')
            ->with('success', 'Datos creados exitosamente.');
    }


    public function edit($id)
    {

        $gobernaciontv = Gestionjakutv::findOrFail($id); // Busca la transmisión por ID
        $categorias = Jakutv::all(); // Consulta de categorías
        return view('gestionjakutv.edit', compact('gobernaciontv', 'categorias')); // Enviando variables a la vista
    }

    public function update(Request $request, $id)
    {
        $gobernaciontv = Gestionjakutv::find($id);

        if (!$gobernaciontv) {
            return redirect()->route('gestionjakutv.index')->with('error', 'Jaku no encontrada.');
        }

        // Validación
        $request->validate([
            'nombre_archivo' => 'required',
            'archivo_tarjeta' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,mp4|max:2048000', // Validar archivos y máximo de 2 GB
            'imagen_portada' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Validación de imagen
            'estado' => 'required',
            'categoriatv_id' => 'required',
        ]);

        // Manejo de actualización de archivo
        if ($request->hasFile('archivo_portada')) {
            $file = $request->file('archivo_portada');
            $nombreArchivo = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/uploads', $nombreArchivo);

            // Eliminar el archivo anterior si es necesario
            if ($gobernaciontv->archivo) {
                Storage::delete('public/uploads/' . $gobernaciontv->archivo);
            }

            // Actualizar con el nuevo archivo
            $gobernaciontv->archivo = $nombreArchivo;
        }

        // Manejo de actualización de archivo
        if ($request->hasFile('imagen_portada')) {
            $fileImagen = $request->file('imagen_portada');
            $nombreImagen = time() . '.' . $fileImagen->getClientOriginalExtension();
            $fileImagen->storeAs('public/uploads', $nombreImagen);

            // Eliminar el archivo anterior si es necesario
            if ($gobernaciontv->imagen_portada) {
                Storage::delete('public/uploads/' . $gobernaciontv->imagen_portada);
            }

            // Actualizar con el nuevo archivo
            $gobernaciontv->imagen_portada = $nombreImagen;
        }


        // echo '<pre>';
        // print_r($gobernaciontv);
        // echo '</pre>';
        // die();


        // Actualizar otros campos
        $gobernaciontv->update([
            'nombre' => $request->input('nombre_archivo'),
            'archivo' => $gobernaciontv->archivo,
            'imagen_portada' => $gobernaciontv->imagen_portada,
            'estado' => $request->input('estado'),
            'categoriatv_id' => $request->input('categoriatv_id'),
        ]);

        return redirect()->route('gestionjakutv.index')->with('success', 'Datos actualizados exitosamente.');
    }


    public function destroy($id)
    {
        // Buscar el registro en la base de datos
        $gobernaciontv = Gestionjakutv::find($id);

        // Verificar si el registro existe
        if ($gobernaciontv) {
            // Eliminar el registro
            $gobernaciontv->delete();

            // Redirigir con mensaje de éxito
            return redirect()->route('gestionjakutv.index')
                ->with('success', 'Datos eliminados exitosamente.');
        } else {
            // Si no se encuentra el registro, redirigir con mensaje de error
            return redirect()->route('gestionjakutv.index')
                ->with('error', 'Registro no encontrado.');
        }
    }
}
