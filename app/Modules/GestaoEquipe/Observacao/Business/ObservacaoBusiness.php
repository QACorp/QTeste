<?php

namespace App\Modules\GestaoEquipe\Observacao\Business;

use App\Modules\GestaoEquipe\Observacao\Contracts\Business\ObservacaoBusinessContract;
use App\Modules\GestaoEquipe\Observacao\Contracts\Respositories\ObservacaoRepositoryContract;
use App\Modules\GestaoEquipe\Observacao\DTOs\ObservacaoDTO;
use App\Modules\GestaoEquipe\Observacao\Enums\PermissionEnum;
use App\System\Contracts\Business\EquipeBusinessContract;
use App\System\Exceptions\NotFoundException;
use App\System\Impl\BusinessAbstract;
use Spatie\LaravelData\DataCollection;

class ObservacaoBusiness extends BusinessAbstract implements ObservacaoBusinessContract
{

    public function __construct(
        private readonly ObservacaoRepositoryContract $observacaoRepository,
        private readonly EquipeBusinessContract $equipeBusiness
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
        // TODO: Implement atualizar() method.
    }

    public function deletar(int $id, int $idEquipe): bool
    {
        // TODO: Implement deletar() method.
    }
}
