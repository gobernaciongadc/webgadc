<?php
namespace App\Http\Controllers;

use App\Services\ParametricaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Notification;
use Toastr;

class ParametricaController extends Controller
{
    protected $parametricaService;
    public function __construct(
        ParametricaService $parametricaService
    )
    {
        $this->parametricaService = $parametricaService;
        $this->middleware('auth');
    }

    public function index()
    {
        $searchtype = 1;
        $search = '';
        $sort = 1;
        $lista = $this->parametricaService->getAllPaginate(15);
        return view('parametrica.index', compact('lista','searchtype','search','sort'));
    }

    public function edit($par_id)
    {
        $parametrica = $this->parametricaService->getById($par_id);
        return view('parametrica.createedit', compact('parametrica'));

    }

    public  function store(Request $request)
    {
        $data = $request->except('_token');
     	if($request->par_id == 0 ) {
        }else{
 
            try {
                $parametrica = $this->parametricaService->update($data);
                if (empty($parametrica)) {
                    Toastr::warning('No se pudo editar la parametrica',"");
                }else{
                    Toastr::success('Operación completada',"");
                    return redirect('sisadmin/parametrica/');
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                Toastr::error('Ocurrio un error al editar la parametrica',"");
                return back()->withInput();
            }
        }
    }






}
