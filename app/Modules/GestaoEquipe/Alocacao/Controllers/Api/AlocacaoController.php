<?php

namespace App\Modules\GestaoEquipe\Alocacao\Controllers\Api;

use App\Modules\GestaoEquipe\Alocacao\Contracts\Business\AlocacaoBusinessContract;
use App\Modules\GestaoEquipe\Alocacao\DTOs\AlocacaoDTO;
use App\System\Exceptions\ConflictException;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AlocacaoController extends Controller
{
    public function __construct(
        private readonly AlocacaoBusinessContract $alocacaoBusiness
    )
    {

    }
    public function marcarAlocacaoComoConcluida(Request $request, int $idAlocacao){
        if(!$request->get('idEquipe')){
            return response()->json(['message' => 'Equipe não informada'], 422);
        }
        try {
            return $this->alocacaoBusiness->marcarAlocacaoComoConcluida($idAlocacao, $request->get('idEquipe'));
        }catch (UnauthorizedException|NotFoundException|ConflictException $e){
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
    public function criarAlocacao(Request $request, AlocacaoDTO $alocacaoDTO){
        try {
            $alocacaoDTO->empresa_id = Auth::guard('api')->user()->empresa_id;
            return $this->alocacaoBusiness->criarAlocacao($alocacaoDTO);
        }catch (UnauthorizedException|ConflictException $e){
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
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
    public function usuariosDisponiveis(Request $request, string $inicio, string $termino)
    {
        $inicio = Carbon::make($inicio);
        $termino = Carbon::make($termino);
        try {
            if (!$request->get('idEquipe')) {
                return response()->json(['message' => 'Equipe não informada'], 422);
            }
            return $this->alocacaoBusiness->usuariosDisponiveis($request->get('idEquipe'), $inicio, $termino);
        }catch (UnauthorizedException $e){
            return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
        }

    }
    public function projetosDisponiveis(Request $request, string $inicio, string $termino)
    {
        $inicio = Carbon::make($inicio);
        $termino = Carbon::make($termino);
        try {
            if (!$request->get('idEquipe')) {
                return response()->json(['message' => 'Equipe não informada'], 422);
            }
            return $this->alocacaoBusiness->buscarProjetosVigentes($request->get('idEquipe'), $inicio, $termino);
        }catch (UnauthorizedException $e){
            return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
        }
    }
    public function listarMinhasAlocacoes(Request $request){
        try{
            return $this->alocacaoBusiness->listarMinhasAlocacoes($request->get('idEquipe'), Auth::guard('api')->user()->getAuthIdentifier());
        }catch (UnauthorizedException $e){
            return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
        }
    }
}
