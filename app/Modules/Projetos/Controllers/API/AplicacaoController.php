<?php

namespace App\Modules\Projetos\Controllers\API;

use App\Modules\Projetos\Contracts\Business\AplicacaoBusinessContract;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Http\Controllers\Controller;

class AplicacaoController extends Controller
{
    public function __construct(
        private readonly AplicacaoBusinessContract $aplicacaoBusiness
    )
    {
    }
    public function listarAplicacoes(int $idEquipe){
        try{
            return response()->json($this->aplicacaoBusiness->buscarTodos($idEquipe,'api'));
        }catch (UnauthorizedException | NotFoundException $e){
            return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
        }

    }
}
