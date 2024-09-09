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
use App\Modules\Projetos\Contracts\Business\ObservacaoBusinessContract;
use App\Modules\Projetos\DTOs\ObservacaoDTO;
use App\System\Contracts\Business\EquipeBusinessContract;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Impl\BusinessAbstract;
use App\System\Traits\TransactionDatabase;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;
use Illuminate\Support\Carbon;
class CheckpointBusiness extends BusinessAbstract implements CheckpointBusinessContract
{
    use TransactionDatabase;
    public function __construct(
        private readonly CheckpointRepositoryContract $checkpointRepository,
        private readonly UserBusinessContract $userBusiness,
        private readonly EquipeBusinessContract $equipeBusiness,
        private readonly ProjetoRepositoryContract $projetoRepository,
        private readonly AlocacaoRepositoryContract $alocacaoRepository,
        private readonly ObservacaoBusinessContract $observacaoBusiness
    )
    {
    }

    public function create(CheckpointDTO $checkpointDTO, int $idEquipe): CheckpointDTO
    {
        $this->can(PermissionEnum::CRIAR_CHECKPOINT->value, 'api');
        if(!$this->equipeBusiness->hasEquipe($idEquipe, Auth::user()->getAuthIdentifier())){
            throw new NotFoundException('Equipe não encontrada.');
        }
        if(!$this->equipeBusiness->hasEquipe($checkpointDTO->equipe_id, $checkpointDTO->criador_user_id)){
            throw new UnauthorizedException('Este usuário criador não pertence à equipe.');
        }
        if(!$this->equipeBusiness->hasEquipe($checkpointDTO->equipe_id, $checkpointDTO->user_id)){
            throw new UnauthorizedException('Este usuário não pertence a equipe.');
        }
        try {
            $this->startTransaction();
            $checkpointDTO = $this->checkpointRepository->create($checkpointDTO, $idEquipe);
            if($checkpointDTO->projeto_id){
                $this->createOberservacao($checkpointDTO);
            }
            $this->commit();
        }catch (NotFoundException | UnauthorizedException $e){
            $this->rollback();
            throw $e;
        }
        return $checkpointDTO;
    }
    private function createOberservacao(CheckpointDTO $checkpointDTO): bool
    {
        $observacaoDTO = ObservacaoDTO::from([
                'observacao' => $this->createDescricaoObservacao($checkpointDTO->descricao),
                'projeto_id' => $checkpointDTO->projeto_id,
                'user_id' => $checkpointDTO->criador_user_id
        ]);
        $this->observacaoBusiness->salvar($observacaoDTO, $checkpointDTO->equipe_id, 'api');
        return true;
    }
    private function createDescricaoObservacao(string $descricao):string
    {
        return $descricao."\r\n[obs]Observação criada através de um checkpoint.[/obs]";
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

    public function listarCheckpointPorAlocacao(int $idEquipe, $idAlocacao): DataCollection
    {
        $this->can(PermissionEnum::VER_CHECKPOINT->value, 'api');
        if(!$this->equipeBusiness->hasEquipe($idEquipe, Auth::user()->getAuthIdentifier())){
            throw new NotFoundException('Equipe não encontrada');
        }
        return $this->checkpointRepository->listarCheckpointPorAlocacao($idEquipe, $idAlocacao);
    }
}
