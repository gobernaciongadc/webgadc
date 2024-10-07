<?php

namespace App\Http\Controllers;

use App\Models\Radiotv;
use Illuminate\Http\Request;

class RadiotvController extends Controller
{
    public function index()
    {

        $transmisiones = Radiotv::all(); // Cambiado a JakuTv
        // $transmisiones = Gobernaciontv::with('categoriaTv')->get();
        return view('radiotv.index', compact('transmisiones')); // Cambiado la vista

    }

    public function create()
    {
        return view('radiotv.create'); // Cambiado la vista
    }

    public function store(Request $request)
    {
        $request->validate([
            'url_radio' => 'required',
            'descripcion' => 'required',
        ]);

        Radiotv::create($request->all()); // Cambiado a Gobernaciontv

        return redirect()->route('radiotv.index') // Cambiado la ruta
            ->with('success', 'Datos creados exitosamente.');
    }


    public function edit($id)
    {
        $gobernaciontv = Radiotv::findOrFail($id); // Busca la transmisión por ID
        return view('radiotv.edit', compact('gobernaciontv')); // Enviando variables a la vista
    }

    public function update(Request $request, $id) // Recibiendo el ID manualmente
    {

        $gobernaciontv = Radiotv::find($id);

        if (!$gobernaciontv) {
            return redirect()->route('radiotv.index')->with('error', 'Radio no encontrada.');
        }

        $request->validate([
            'url_radio' => 'required',
            'descripcion' => 'required',
            'estado' => 'required'
        ]);

        // Actualizar solo los campos necesarios
        $gobernaciontv->update($request->only(['url_radio', 'descripcion', 'estado']));

        return redirect()->route('radiotv.index')->with('success', 'Datos actualizados exitosamente.');
    }

    public function destroy(Request $request, $id)
    {
        // Cambiar el estado a "inactivo"
        $radiotv = Radiotv::findOrFail($id); // Busca la transmisión por ID
        $radiotv->update(['estado' => 'off']);

        return redirect()->route('radiotv.index')
            ->with('success', 'El estado ha sido actualizado exitosamente.');
    }
}
