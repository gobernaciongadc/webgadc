<?php


namespace App\Http\Controllers;

use App\Models\Gobernaciontv; // Cambiado a Gobernaciontv
use App\Models\Categoriatv;
use Illuminate\Http\Request;

class CategoriatvController extends Controller
{
    public function index()
    {

        $transmisiones = Categoriatv::all(); // Cambiado a CategoriaTv
        // $transmisiones = Gobernaciontv::with('categoriaTv')->get();

        return view('categoriatv.index', compact('transmisiones')); // Cambiado la vista
    }

    public function create()
    {
        return view('categoriatv.create'); // Cambiado la vista
    }

    public function store(Request $request)
    {


        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);

        Categoriatv::create($request->all()); // Cambiado a Gobernaciontv

        return redirect()->route('categoriatv.index') // Cambiado la ruta
            ->with('success', 'Categoria creada exitosamente.');
    }


    public function edit($id)
    {
        $gobernaciontv = Categoriatv::findOrFail($id); // Busca la transmisión por ID
        return view('categoriatv.edit', compact('gobernaciontv')); // Enviando variables a la vista
    }

    public function update(Request $request, $id) // Recibiendo el ID manualmente
    {

        $gobernaciontv = Categoriatv::find($id);

        if (!$gobernaciontv) {
            return redirect()->route('categoriatv.index')->with('error', 'Categoria no encontrada.');
        }

        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'estado' => 'required'
        ]);

        // Actualizar solo los campos necesarios
        $gobernaciontv->update($request->only(['nombre', 'descripcion', 'estado']));

        return redirect()->route('categoriatv.index')->with('success', 'Datos actualizados exitosamente.');
    }

    public function destroy(Request $request, $id)
    {
        // Cambiar el estado a "inactivo"
        $categoriatv = Categoriatv::findOrFail($id); // Busca la transmisión por ID
        $categoriatv->update(['estado' => 'off']);

        return redirect()->route('categoriatv.index')
            ->with('success', 'El estado ha sido actualizado exitosamente.');
    }
}
