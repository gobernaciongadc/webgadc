<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Radiotv;


class RadiotvControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $radiotv = Radiotv::all();
        $data = array(
            'code' => 200,
            'status' => 'success',
            'radiotv' => $radiotv
        );
        return response()->json($data, $data['code']);
    }
}
