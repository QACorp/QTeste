<?php

namespace App\Modules\GestaoEquipe\Observacao\Controllers\API;

use App\Modules\GestaoEquipe\Checkpoint\Contracts\Business\CheckpointBusinessContract;
use App\Modules\GestaoEquipe\Checkpoint\DTOs\CheckpointDTO;
use App\Modules\GestaoEquipe\Observacao\Contracts\Business\ObservacaoBusinessContract;
use App\Modules\GestaoEquipe\Observacao\DTOs\ObservacaoDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Http\Controllers\Controller;
use App\System\Traits\RequestGuardTraits;
use App\System\Utils\EquipeUtils;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ObservacaoController extends Controller
{
    use RequestGuardTraits;
    public function __construct(
        private readonly ObservacaoBusinessContract $observacaoBusiness,

    )
    {
    }
    public function lista(Request $request, int $idUsuario)
    {
        if (!$request->get('idEquipe')){
            return response()->json(['message' => 'Equipe não informada'], 400);
        }
        try {
            return $this->observacaoBusiness->listaPorIdUsuario(
                $idUsuario,
                $request->get('idEquipe'),
                Auth::user()->getAuthIdentifier()
            );
        } catch (UnauthorizedException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

    }
    public function salvar(ObservacaoDTO $observacaoDTO)
    {
        if (!request()->get('idEquipe')){
            return response()->json(['message' => 'Equipe não informada'], 400);
        }
        $observacaoDTO->criador_user_id = Auth::user()->getAuthIdentifier();
        try {
            return $this->observacaoBusiness->salvar(
                $observacaoDTO,
                request()->get('idEquipe')
            );
        } catch (UnauthorizedException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }
    public function remover(Request $request, int $idObservacao){
        if (!$request->get('idEquipe')){
            return response()->json(['message' => 'Equipe não informada'], 400);
        }
        try {
            return $this->observacaoBusiness->deletar(
                $idObservacao,
                $request->get('idEquipe')
            );
        } catch (UnauthorizedException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }
    public function alterar(Request $request, int $idObservacao){
        if (!$request->get('idEquipe')){
            return response()->json(['message' => 'Equipe não informada'], 400);
        }
        if(!$request->get('observacao')){
            return response()->json(['message' => 'Observação não informada'], 400);
        }
        $observacaoDTO = ObservacaoDTO::from($request->only('observacao'));
        try {
            return $this->observacaoBusiness->atualizar(
                $idObservacao,
                $observacaoDTO,
                $request->get('idEquipe')
            );
        } catch (UnauthorizedException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

}
