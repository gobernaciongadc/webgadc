<?php

namespace App\Http\Controllers;

use App\Models\Transmision;
use Illuminate\Http\Request;

class TransmisionController extends Controller
{
    public function index()
    {
        $transmisiones = Transmision::all();
        return view('transmisiones.index', compact('transmisiones'));
    }

    public function create()
    {
        // Verificar si hay alguna transmisión con estado 'live'
        if (Transmision::where('estado', 'live')->exists()) {
            return redirect()->route('transmisiones.index')
                ->with('error', 'No se puede crear una nueva transmisión mientras existe una transmisión en vivo.');
        }

        return view('transmisiones.create');
    }

    public function store(Request $request)
    {
        // Verificar si hay alguna transmisión con estado 'live'
        if (Transmision::where('estado', 'live')->exists()) {
            return redirect()->route('transmisiones.index')
                ->with('error', 'No se puede crear una nueva transmisión mientras existe una transmisión en vivo.');
        }

        $request->validate([
            'programa' => 'required',
            'horario' => 'required',
            'descripcion' => 'required',
            'plataforma' => 'required',
            'estado' => 'required',
        ]);

        Transmision::create($request->all());

        return redirect()->route('transmisiones.index')
            ->with('success', 'Transmisión creada exitosamente.');
    }

    public function edit(Transmision $transmision)
    {
        return view('transmisiones.edit', compact('transmision'));
    }

    public function update(Request $request, Transmision $transmision)
    {
        $request->validate([
            'programa' => 'required',
            'horario' => 'required',
            'descripcion' => 'required',
            'plataforma' => 'required',
            'estado' => 'required',
        ]);

        $transmision->update($request->all());

        return redirect()->route('transmisiones.index')
            ->with('success', 'Transmisión actualizada exitosamente.');
    }

    public function destroy(Transmision $transmision)
    {
        $transmision->delete();

        return redirect()->route('transmisiones.index')
            ->with('success', 'Transmisión eliminada exitosamente.');
    }
}
