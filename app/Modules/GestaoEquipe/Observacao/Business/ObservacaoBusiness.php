<?php

namespace App\Modules\GestaoEquipe\Observacao\Business;

use App\Modules\GestaoEquipe\Checkpoint\Contracts\Business\CheckpointBusinessContract;
use App\Modules\GestaoEquipe\DTOs\CheckpointObservacaoDTO;
use App\Modules\GestaoEquipe\Observacao\Contracts\Business\ObservacaoBusinessContract;
use App\Modules\GestaoEquipe\Observacao\Contracts\Respositories\ObservacaoRepositoryContract;
use App\Modules\GestaoEquipe\Observacao\DTOs\ObservacaoDTO;
use App\Modules\GestaoEquipe\Observacao\Enums\PermissionEnum;
use App\System\Contracts\Business\EquipeBusinessContract;
use App\System\Exceptions\NotFoundException;
use App\System\Impl\BusinessAbstract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\DataCollection;
use App\Modules\GestaoEquipe\Checkpoint\Enums\PermissionEnum as CheckpointPermissionEnum;

class ObservacaoBusiness extends BusinessAbstract implements ObservacaoBusinessContract
{

    public function __construct(
        private readonly ObservacaoRepositoryContract $observacaoRepository,
        private readonly EquipeBusinessContract $equipeBusiness,
        private readonly CheckpointBusinessContract $checkpointBusiness
    )
    {
    }
    public function hasEquipe(int $idEquipe, int $idUsuario, $idUsuarioCriador): bool
    {
        return $this->equipeBusiness->hasEquipe($idEquipe, $idUsuario) ||
                $this->equipeBusiness->hasEquipe($idEquipe, $idUsuarioCriador);
    }
    public function listaPorIdUsuario(int $idUsuario, int $idEquipe, int $idUsuarioCriador): DataCollection
    {
        $this->can(PermissionEnum::LISTAR_OBSERVACAO->value);
        if(!$this->hasEquipe($idEquipe, $idUsuario, $idUsuarioCriador)){
            throw new NotFoundException('Equipe não encontrada');
        }

        return $this->observacaoRepository->listaPorIdUsuario($idUsuario, $idEquipe, $idUsuarioCriador);
    }


    public function salvar(ObservacaoDTO $observacaoDTO, int $idEquipe): ObservacaoDTO
    {
        $this->can(PermissionEnum::INSERIR_OBSERVACAO->value);
        if(!$this->hasEquipe($idEquipe, $observacaoDTO->user_id, $observacaoDTO->criador_user_id)){
            throw new NotFoundException('Equipe não encontrada');
        }
        $observacao = $this->observacaoRepository->salvar($observacaoDTO, $idEquipe);
        return ObservacaoDTO::from($observacao);
    }

    public function atualizar(int $id, ObservacaoDTO $observacaoDTO, int $idEquipe): ObservacaoDTO
    {
        $this->can(PermissionEnum::ALTERAR_OBSERVACAO->value);
        $observacao = $this->observacaoRepository->buscarPorId($id, $idEquipe);

        if(!$observacao){
            throw new NotFoundException('Observação não encontrada');
        }
        if(!$this->hasEquipe($idEquipe, $observacao->user_id, $observacao->criador_user_id)){
            throw new NotFoundException('Observação não encontrada');
        }
        return $this->observacaoRepository->atualizar($id, $observacaoDTO, $idEquipe);


    }

    public function deletar(int $id, int $idEquipe): bool
    {
        $this->can(PermissionEnum::REMOVER_OBSERVACAO->value);
        $observacao = $this->observacaoRepository->buscarPorId($id, $idEquipe);
        if(!$observacao){
            throw new NotFoundException('Observação não encontrada');
        }
        if(!$this->hasEquipe($idEquipe, $observacao->user_id, $observacao->criador_user_id)){
            throw new NotFoundException('Observação não encontrada');
        }
        return $this->observacaoRepository->deletar($id, $idEquipe);
    }

    public function buscarObservacaoComCheckpoint(int $idUsuario, int $idEquipe): DataCollection
    {
        if(!$this->equipeBusiness->hasEquipe($idEquipe, Auth::user()->getAuthIdentifier())){
            throw new NotFoundException('Equipe não encontrada');
        }
        if($this->canDo(PermissionEnum::LISTAR_OBSERVACAO->value) &&
            $this->canDo(CheckpointPermissionEnum::VER_CHECKPOINT->value))
        {
            return $this->observacaoRepository->buscarObservacaoComCheckpoint($idUsuario, $idEquipe);
        }
        if($this->canDo(PermissionEnum::LISTAR_OBSERVACAO->value)){
            return CheckpointObservacaoDTO::collection(
                $this->gerarCheckpointObservacaoPorObservacao(
                    $this->observacaoRepository->listaPorIdUsuario($idUsuario, $idEquipe, Auth::user()->getAuthIdentifier())
                )

            );
        }
        if($this->canDo(CheckpointPermissionEnum::VER_CHECKPOINT->value)){
            return CheckpointObservacaoDTO::collection(
                $this->gerarCheckpointObservacaoPorCheckpoint($this->checkpointBusiness->listarCheckpointsPorUsuario($idEquipe, $idUsuario))
            );
        }

        return CheckpointObservacaoDTO::collection(Collection::empty());
    }
    private function gerarCheckpointObservacaoPorObservacao(DataCollection $collection): DataCollection
    {
        return $collection->map(function($observacao){
                return CheckpointObservacaoDTO::from([
                    'id' => $observacao->id,
                    'descricao' => $observacao->observacao,
                    'data' => $observacao->data,
                    'user_id' => $observacao->user_id,
                    'criador_user_id' => $observacao->criador_user_id,
                    'user' => $observacao->user,
                    'criador' => $observacao->criador,
                    'tipo' => 'Observacao'
                ]);
            });
    }
    private function gerarCheckpointObservacaoPorCheckpoint(DataCollection $collection): DataCollection
    {
        return $collection->map(function($checkpoint){
            return CheckpointObservacaoDTO::from([
                'id' => $checkpoint->id,
                'descricao' => $checkpoint->descricao,
                'data' => $checkpoint->data,
                'user_id' => $checkpoint->user_id,
                'criador_user_id' => $checkpoint->criador_user_id,
                'user' => $checkpoint->user,
                'criador' => $checkpoint->criador,
                'projeto' => $checkpoint->projeto,
                'tarefa'  => $checkpoint->tarefa,
                'tipo'    => 'Checkpoint'
            ]);
        });
    }
}
