<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Modaltv;
use App\Models\Radiotv;


class ModaltvControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modaltv = Modaltv::all();
        $data = array(
            'code' => 200,
            'status' => 'success',
            'modaltv' => $modaltv
        );
        return response()->json($data, $data['code']);
    }
}
