<?php

namespace App\Modules\Projetos\Controllers\API;

use App\Modules\Projetos\Contracts\Business\ProjetoBusinessContract;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Http\Controllers\Controller;

class ProjetoController extends Controller
{
    public function __construct(
        private readonly ProjetoBusinessContract $projetoBusiness
    )
    {
    }
    public function listarProjetosPorEquipe(int $idEquipe){
        try{
            return response()->json($this->projetoBusiness->buscarTodosPorEquipe($idEquipe, 'api'));
        }catch (UnauthorizedException | NotFoundException $e){
            return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
        }

    }
    public function listarProjetosPorAplicacao(int $idEquipe, int $idAplicacao){
        try{
            return response()->json($this->projetoBusiness->buscarTodosPorAplicacao($idEquipe, $idAplicacao, 'api'));
        }catch (UnauthorizedException | NotFoundException $e){
            return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
        }

    }
}
