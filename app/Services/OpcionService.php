<?php
namespace App\Services;


use App\Repositories\OpcionRepository;
use Illuminate\Support\Facades\Log;

class OpcionService
{
    protected $opcionRepository;
    public function __construct(OpcionRepository $opcionRepository)
    {
        $this->opcionRepository = $opcionRepository;
    }

    public function getLista($pre_id)
    {
        return $this->opcionRepository->getLista($pre_id);
    }



}
