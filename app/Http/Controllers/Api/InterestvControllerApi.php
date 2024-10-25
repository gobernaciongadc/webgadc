<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Interestv;

class InterestvControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interestv = Interestv::orderby('id', 'desc')->get();
        $data = array(
            'code' => 200,
            'status' => 'success',
            'interestv' => $interestv
        );
        return response()->json($data, $data['code']);
    }
}
