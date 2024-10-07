<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gobernaciontv;
use App\Models\Jakutv;
use App\Models\Transmision;


class JakutvControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jakutv = Jakutv::orderBy('created_at', 'desc')->limit(10)->get();
        $data = array(
            'code' => 200,
            'status' => 'success',
            'jakutv' => $jakutv
        );
        return response()->json($data, $data['code']);
    }
}
