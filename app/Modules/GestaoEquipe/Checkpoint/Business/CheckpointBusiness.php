<?php

namespace App\Modules\GestaoEquipe\Checkpoint\Business;

use App\Modules\GestaoEquipe\Checkpoint\Contracts\Business\CheckpointBusinessContract;
use App\Modules\GestaoEquipe\Checkpoint\Contracts\Business\UserBusinessContract;
use App\Modules\GestaoEquipe\Checkpoint\Contracts\Respositories\CheckpointRepositoryContract;
use App\Modules\GestaoEquipe\Checkpoint\DTOs\CheckpointDTO;
use App\System\Contracts\Business\EquipeBusinessContract;
use App\System\Exceptions\NotFoundException;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

class CheckpointBusiness implements CheckpointBusinessContract
{
    public function __construct(
        private readonly CheckpointRepositoryContract $checkpointRepository,
        private readonly UserBusinessContract $userBusiness,
        private readonly EquipeBusinessContract $equipeBusiness
    )
    {
    }

    public function create(CheckpointDTO $checkpointDTO, int $idEquipe): CheckpointDTO
    {
        // TODO: Implement create() method.
    }

    public function update(CheckpointDTO $checkpointDTO): CheckpointDTO
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id): bool
    {
        // TODO: Implement delete() method.
    }

    public function list(int $idEquipe): DataCollection
    {
        return $this->checkpointRepository->list($idEquipe);
    }

    public function getCheckpoint(int $id): CheckpointDTO
    {
        // TODO: Implement getCheckpoint() method.
    }

    public function getListUser(int $idEquipe, int $page = null, int $limit = null): DataCollection|PaginatedDataCollection
    {
        if(!$this->equipeBusiness->hasEquipe($idEquipe, Auth::user()->getAuthIdentifier())){
            throw new NotFoundException('Equipe não encontrada');
        }
        return $this->userBusiness->listarUsuariosPaginado($idEquipe, $page, $limit);
    }
}
