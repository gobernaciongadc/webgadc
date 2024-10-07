<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gestionjakutv;
use App\Models\Gobernaciontv;
use App\Models\Jakutv;
use App\Models\Transmision;


class GestionjakuControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gestionjakutv = Gestionjakutv::where('categoriatv_id', $id)
            ->where('estado', 'live')
            ->orderBy('created_at', 'desc')
            ->get();

        $data = array(
            'code' => 200,
            'status' => 'success',
            'gestionjakutv' => $gestionjakutv
        );
        return response()->json($data, $data['code']);
    }
}
