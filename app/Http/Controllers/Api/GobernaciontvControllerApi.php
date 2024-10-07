<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gobernaciontv;
use App\Models\Transmision;


class GobernaciontvControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $gobernaciontv = Gobernaciontv::with('categoriaTv')->orderBy('created_at', 'desc')->limit(10)->get();


        $data = array(
            'code' => 200,
            'status' => 'success',
            'gobernaciontv' => $gobernaciontv
        );
        return response()->json($data, $data['code']);
    }
}
