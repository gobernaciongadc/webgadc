<?php

namespace App\Http\Controllers;

use App\Services\UnidadService;
use Illuminate\Http\Request;
use Toastr;

class HomeController extends Controller
{
    protected $unidadService;
    public function __construct(UnidadService $unidadService)
    {
        $this->unidadService = $unidadService;
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Toastr::warning('Porrrr fabor registre sus datos de Productor!', "");
        return view('home');
    }

    public function index2()
    {
        //Toastr::warning('Porrrr fabor registre sus datos de Productor!', "");
        return view('home');
    }

    public function getUnidadDespacho()
    {
        $despacho = $this->unidadService->getUnidadDespacho();
        return response()->json([
            'res' => true,
            'data'=>$despacho->toArray()
        ],200);
    }

}
