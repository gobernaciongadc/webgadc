<?php
namespace App\Http\Controllers;

use App\Services\SugerenciaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Notification;
use Toastr;

class SugerenciaController extends Controller
{
    protected $sugerenciaService;
    public function __construct(
        SugerenciaService $sugerenciaService
    )
    {
        $this->sugerenciaService = $sugerenciaService;
        $this->middleware('auth');
    }

    public function index()
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $lista = $this->sugerenciaService->getAllPaginate(10);
        return view('sugerencia.index', compact('lista','searchtype','search','sort'));
    }

    public function show($sur_id)
    {
        $Sugerencia = $this->sugerenciaService->getById($sur_id);
        return view('sugerencia.show', compact('Sugerencia'));

    }



}
