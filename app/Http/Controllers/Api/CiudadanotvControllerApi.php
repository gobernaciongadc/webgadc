<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ciudadanotv;
use App\Models\Modaltv;
use App\Models\Radiotv;


class CiudadanotvControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ciudadanotv = Ciudadanotv::where('estado', 'live')->get();
        $data = array(
            'code' => 200,
            'status' => 'success',
            'ciudadanotv' => $ciudadanotv
        );
        return response()->json($data, $data['code']);
    }
}
