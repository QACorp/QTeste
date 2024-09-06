<?php

namespace App\Modules\GestaoEquipe\Checkpoint\Business;

use App\Modules\GestaoEquipe\Alocacao\Contracts\Repositories\AlocacaoRepositoryContract;
use App\Modules\GestaoEquipe\Checkpoint\Contracts\Business\CheckpointBusinessContract;
use App\Modules\GestaoEquipe\Checkpoint\Contracts\Business\UserBusinessContract;
use App\Modules\GestaoEquipe\Checkpoint\Contracts\Respositories\CheckpointRepositoryContract;
use App\Modules\GestaoEquipe\Checkpoint\Contracts\Respositories\ProjetoRepositoryContract;
use App\Modules\GestaoEquipe\Checkpoint\DTOs\CheckpointDTO;
use App\Modules\GestaoEquipe\Checkpoint\Enums\PermissionEnum;
use App\Modules\GestaoEquipe\Alocacao\Enums\PermissionEnum as PermissionAlocacaoEnum;
use App\System\Contracts\Business\EquipeBusinessContract;
use App\System\Exceptions\NotFoundException;
use App\System\Impl\BusinessAbstract;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;
use Illuminate\Support\Carbon;
class CheckpointBusiness extends BusinessAbstract implements CheckpointBusinessContract
{
    public function __construct(
        private readonly CheckpointRepositoryContract $checkpointRepository,
        private readonly UserBusinessContract $userBusiness,
        private readonly EquipeBusinessContract $equipeBusiness,
        private readonly ProjetoRepositoryContract $projetoRepository,
        private readonly AlocacaoRepositoryContract $alocacaoRepository
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

    public function getLastCheckpoint(int $idEquipe, int $idUsuario): ?CheckpointDTO
    {
        $this->can(PermissionEnum::VER_CHECKPOINT->value, 'api');
        if(!$this->equipeBusiness->hasEquipe($idEquipe, Auth::user()->getAuthIdentifier())){
            throw new NotFoundException('Equipe não encontrada');
        }
        return $this->checkpointRepository->getLastCheckpoint($idEquipe, $idUsuario);

    }

    public function getProjetos(int $idEquipe): DataCollection
    {
        if(!$this->equipeBusiness->hasEquipe($idEquipe, Auth::user()->getAuthIdentifier())){
            throw new NotFoundException('Equipe não encontrada');
        }
        return $this->projetoRepository->getProjetos($idEquipe);
    }

    public function listarAlocacoesPorData(int $idEquipe, int $idUsuario, Carbon $data): DataCollection
    {
        $this->can(PermissionAlocacaoEnum::VER_ALOCACAO->value, 'api');
        if(!$this->equipeBusiness->hasEquipe($idEquipe, Auth::user()->getAuthIdentifier())){
            throw new NotFoundException('Equipe não encontrada');
        }

        return $this->alocacaoRepository->listarAlocacoesPorData($idEquipe, $idUsuario, $data);
    }
}
