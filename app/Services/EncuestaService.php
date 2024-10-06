<?php
namespace App\Services;

use App\Repositories\EncuestaRepository;
use Illuminate\Support\Facades\Log;

class EncuestaService
{

    protected $encuestaRepository;
    public function __construct(EncuestaRepository $encuestaRepository)
    {
        $this->encuestaRepository = $encuestaRepository;
    }

    public function getAllPaginate($limit)
    {
        return $this->encuestaRepository->getAllPaginate($limit);
    }
   
}

