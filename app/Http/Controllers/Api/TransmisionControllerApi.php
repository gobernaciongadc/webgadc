<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transmision;


class TransmisionControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $transmision = Transmision::all();

        $data = array(
            'code' => 200,
            'status' => 'success',
            'transmision' => $transmision
        );
        return response()->json($data, $data['code']);
    }
}
