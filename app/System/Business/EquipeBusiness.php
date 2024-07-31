<?php

namespace App\System\Business;

use App\System\Contracts\Business\EquipeBusinessContract;
use App\System\Contracts\Repository\EquipeRepositoryContract;
use App\System\DTOs\EquipeDTO;
use App\System\Enums\PermissionEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Impl\BusinessAbstract;
use App\System\Requests\EquipePostRequest;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\DataCollection;

class EquipeBusiness extends BusinessAbstract implements EquipeBusinessContract
{
    public function __construct(
        private readonly EquipeRepositoryContract $equipeRepository
    )
    {
    }
    public function hasEquipe(int $idEquipe, int $idUsuario): bool
    {
        return $this->equipeRepository->hasEquipe($idEquipe, $idUsuario);
    }
    public function buscarTodos(): DataCollection
    {
        $this->can(PermissionEnum::LISTAR_EQUIPE->value);
        return $this->equipeRepository->buscarTodos();
    }

    public function inserir(EquipeDTO $equipe, EquipePostRequest $equipePostRequest = new EquipePostRequest()): EquipeDTO
    {
        $this->can(PermissionEnum::INSERIR_EQUIPE->value);
        $validator = Validator::make($equipe->toArray(), $equipePostRequest->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }
        return $this->equipeRepository->inserir($equipe);
    }

    public function buscarEquipePorId(int $idEquipe): EquipeDTO
    {
        $this->can(PermissionEnum::ALTERAR_EQUIPE->value);
        $equipe = $this->equipeRepository->buscarEquipePorId($idEquipe);
        if($equipe == null){
            throw new NotFoundException();
        }
        return $equipe;
    }

    public function alterar(EquipeDTO $equipe, EquipePostRequest $equipePostRequest = new EquipePostRequest()): EquipeDTO
    {
        $this->can(PermissionEnum::ALTERAR_EQUIPE->value);
        $validator = Validator::make($equipe->toArray(), $equipePostRequest->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }
        $this->buscarEquipePorId($equipe->id);
        $equipe = $this->equipeRepository->alterar($equipe);
        return $equipe;

    }
}
