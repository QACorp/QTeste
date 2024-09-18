<?php

namespace App\Modules\Retrabalhos\Controllers\API;

use App\Modules\Retrabalhos\Contracts\Business\RetrabalhoBusinessContract;
use App\Modules\Retrabalhos\DTOs\RetrabalhoCasoTesteDTO;
use App\Modules\Retrabalhos\Enums\CriticidadeEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Exceptions\UnprocessableEntityException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RetrabalhosController
{
    public function __construct(
        public readonly RetrabalhoBusinessContract $retrabalhoBusiness
    )
    {
    }

    public function listarRetrabalhos(Request $request, int $idEquipe)
    {
        try {
            $this->retrabalhoBusiness->buscarTodosPorEquipe($idEquipe, Auth::user()->getAuthIdentifier());
        } catch (UnauthorizedException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

    }

    public function listarRetrabalhosPorUsuarioLogado()
    {
        try {
            return $this->retrabalhoBusiness->buscarTodosPorUsuario(Auth::user()->getAuthIdentifier());
        } catch (UnauthorizedException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

    }
    public function listarRetrabalhosPorUsuario(int $idUsuario)
    {
        try {
            $this->retrabalhoBusiness->buscarTodosPorUsuario($idUsuario);
        } catch (UnauthorizedException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

    }
    public function alterarRetrabalho(RetrabalhoCasoTesteDTO $retrabalhoDTO, int $idRetrabalho)
    {

        if(!request()->get('idEquipe')){
            return response()->json(['message' => 'Equipe não informada'], 422);
        }
        $retrabalhoDTO->id = $idRetrabalho;
        try{
            return $this->retrabalhoBusiness->editar($retrabalhoDTO, Auth::user()->getAuthIdentifier(), request()->get('idEquipe'));

        } catch (UnauthorizedException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }catch (UnprocessableEntityException $e) {
            return response()->json(['message' => $e->getValidator()->getMessageBag()], $e->getCode());
        }


    }

    public function excluirRetrabalho(int $idRetrabalho)
    {
        return $this->retrabalhoBusiness->remover($idRetrabalho, Auth::user()->getAuthIdentifier());

    }

    public function inserirRetrabalho(RetrabalhoCasoTesteDTO $retrabalhoDTO)
    {
        if(!request()->get('idEquipe')){
            return response()->json(['message' => 'Equipe não informada'], 422);
        }
        $retrabalhoDTO->usuario_criador_id = Auth::user()->getAuthIdentifier();
        try {
            return $this->retrabalhoBusiness->salvar($retrabalhoDTO, request()->get('idEquipe'));
        } catch (UnauthorizedException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }catch (UnprocessableEntityException $e) {
            return response()->json(['message' => $e->getValidator()->getMessageBag()], $e->getCode());
        }
    }
    public function buscarRetrabalho(int $idRetrabalho){
        try {
            return $this->retrabalhoBusiness->buscarPorId($idRetrabalho, Auth::user()->getAuthIdentifier());
        }catch (UnauthorizedException|NotFoundException $e){
            return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
        }

    }
    public function listarCriticidade()
    {
        return CriticidadeEnum::cases();
    }
}
