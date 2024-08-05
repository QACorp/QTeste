<?php

namespace App\Modules\GestaoEquipe\Controllers\Api;

use App\Modules\GestaoEquipe\Contracts\Business\AlocacaoBusinessContract;
use App\Modules\GestaoEquipe\DTOs\AlocacaoDTO;
use App\System\Exceptions\ConflictException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Http\Controllers\Controller;
use App\System\Utils\EquipeUtils;
use Illuminate\Http\Request;

class AlocacaoController extends Controller
{
    public function __construct(
        private readonly AlocacaoBusinessContract $alocacaoBusiness
    )
    {

    }
    public function criarAlocacao(AlocacaoDTO $alocacaoDTO){
        // TODO: Implement consultarAlocacao() method.
    }
    public function alterarAlocacao(AlocacaoDTO $alocacaoDTO, int $idAlocacao){
        try {
            return $this->alocacaoBusiness->alterarAlocacao($idAlocacao, $alocacaoDTO);
        }catch (UnauthorizedException|ConflictException $e){
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

    }
    public function excluirAlocacao(int $id){
        // TODO: Implement consultarAlocacao() method.
    }
    public function listarAlocacoes(Request $request){
        try{
            if(!$request->get('idEquipe')){
                return response()->json(['message' => 'Equipe não informada'], 422);
            }
            return $this->alocacaoBusiness->listarAlocacoes($request->get('idEquipe'));
        }catch (UnauthorizedException $e){
            return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
        }

    }
    public function consultarAlocacao(Request $request, int $idAlocacao){
        try{
            if(!$request->get('idEquipe')){
                return response()->json(['message' => 'Equipe não informada'], 422);
            }
            return $this->alocacaoBusiness->consultarAlocacao($idAlocacao, $request->get('idEquipe'));
        }catch (UnauthorizedException $e){
            return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
        }

    }





}
