<?php
namespace App\Http\Controllers;

use App\Services\DenunciaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Notification;
use Toastr;

class DenunciaController extends Controller
{
    protected $denunciaService;
    public function __construct(
        DenunciaService $denunciaService
    )
    {
        $this->denunciaService = $denunciaService;
        $this->middleware('auth');
    }

    public function index()
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $lista = $this->denunciaService->getAllPaginate(10);
        return view('denuncia.index', compact('lista','searchtype','search','sort'));
    }

    public function show($den_id)
    {
        $Denuncia = $this->denunciaService->getById($den_id);
        return view('denuncia.show', compact('Denuncia'));

    }



}
