<?php

namespace App\Http\Controllers;

use App\Models\ConSemanario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ConSemanarioRequest;
use App\Models\ImgSemanario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ConSemanarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $conSemanarios = ConSemanario::paginate();

        return view('con-semanarios.index', compact('conSemanarios'))
            ->with('i', ($request->input('page', 1) - 1) * $conSemanarios->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $conSemanario = new ConSemanario();

        // Pasamos el seminario a la vista
        $imagenes = [];

        return view('con-semanarios.create', compact('conSemanario', 'imagenes'));
    }



    public function store(ConSemanarioRequest $request): RedirectResponse
    {
        // Primero, validamos los datos del formulario
        $validatedData = $request->validated();

        // Iniciar la transacción
        DB::beginTransaction();

        try {
            // Guardamos el seminario primero para obtener el ID
            $seminario = ConSemanario::create($validatedData);

            // Verificamos si el request tiene imágenes
            if ($request->hasFile('imagenes')) {
                // Procesamos cada archivo
                foreach ($request->file('imagenes') as $imagen) {
                    // Almacenar la imagen en la carpeta "public/uploads"
                    $path = $imagen->store('public/uploads');

                    // Guardamos la ruta en la tabla img_seminarios
                    ImgSemanario::create([
                        'semanario_id' => $seminario->id, // ID del seminario creado
                        'imagen' => basename($path), // Solo el nombre del archivo
                    ]);
                }
            }

            // Confirmar la transacción
            DB::commit();

            // Redirigimos con un mensaje de éxito
            return Redirect::route('con-semanarios.index')
                ->with('success', 'ConSemanario creado exitosamente.');
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollBack();

            // Redirigimos con un mensaje de error
            return Redirect::route('con-semanarios.index')
                ->with('error', 'Error al crear el ConSemanario: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $conSemanario = ConSemanario::find($id);

        return view('con-semanarios.show', compact('conSemanario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        // Encontramos el seminario
        $conSemanario = ConSemanario::find($id);

        // Encontramos las imágenes asociadas al seminario
        $imagenes = ImgSemanario::where('semanario_id', $id)->get();


        // Pasamos los datos del seminario y las imágenes a la vista
        return view('con-semanarios.edit', compact('conSemanario', 'imagenes'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ConSemanarioRequest $request, ConSemanario $conSemanario): RedirectResponse
    {
        // Recuperar el ID desde el request
        $id = $request->input('id');

        $params = $request->all();

        // Buscar el modelo por el ID
        $conSemanario = ConSemanario::findOrFail($id);

        // Validar los datos del request
        $validatedData = $request->validated();

        if (!isset($params['eliminar_imagenes'])) {
            $params['eliminar_imagenes'] = [];
        }

        if (!isset($params['imagenes'])) {
            $params['imagenes'] = [];
        }


        try {
            // Iniciar la transacción para asegurar la consistencia de los datos
            DB::beginTransaction();

            // Actualizar los datos del seminario
            $conSemanario->update($validatedData);

            // Procesar la eliminación de imágenes si hay alguna marcada para eliminar
            if (count($params['eliminar_imagenes']) > 0) {

                foreach ($params['eliminar_imagenes'] as $imagenId) {
                    // Buscar la imagen por su ID
                    $imagen = ImgSemanario::findOrFail($imagenId);

                    // Eliminar el archivo físico de la carpeta
                    Storage::delete('public/uploads/' . $imagen->imagen);

                    // Eliminar el registro de la base de datos
                    $imagen->delete();
                }
            }



            // Verificar si el request tiene nuevas imágenes para subir
            if ($request->hasFile('imagenes')) {
                foreach ($request->file('imagenes') as $imagen) {
                    // Subir la nueva imagen a la carpeta "public/uploads"
                    $path = $imagen->store('public/uploads');

                    // Guardar la referencia de la imagen en la base de datos
                    ImgSemanario::create([
                        'semanario_id' => $conSemanario->id,
                        'imagen' => basename($path),
                    ]);
                }
            }

            // Confirmar la transacción
            DB::commit();

            return Redirect::route('con-semanarios.index')
                ->with('success', 'ConSemanario actualizado exitosamente');
        } catch (\Exception $e) {
            // En caso de error, revertir la transacción
            DB::rollBack();

            return Redirect::back()
                ->with('error', 'Error al actualizar: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function destroy($id): RedirectResponse
    {
        try {
            // Iniciar una transacción para asegurar que todo se ejecute correctamente
            DB::beginTransaction();

            // Buscar el seminario por su ID
            $conSemanario = ConSemanario::findOrFail($id);

            // Obtener todas las imágenes relacionadas con el seminario
            $imagenes = ImgSemanario::where('semanario_id', $conSemanario->id)->get();

            // Eliminar cada imagen relacionada
            foreach ($imagenes as $imagen) {
                // Eliminar el archivo físico de la carpeta "public/uploads"
                Storage::delete('public/uploads/' . $imagen->imagen);

                // Eliminar el registro de la imagen en la base de datos
                $imagen->delete();
            }

            // Eliminar el seminario
            $conSemanario->delete();

            // Confirmar la transacción
            DB::commit();

            return Redirect::route('con-semanarios.index')
                ->with('success', 'ConSemanario e imágenes relacionadas eliminados correctamente.');
        } catch (\Exception $e) {
            // En caso de error, revertir los cambios
            DB::rollBack();

            return Redirect::back()
                ->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }
}
