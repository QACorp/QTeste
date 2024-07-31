<?php

namespace App\Modules\GestaoEquipe\Business;

use App\Modules\GestaoEquipe\Contracts\Business\AlocacaoBusinessContract;
use App\Modules\GestaoEquipe\Contracts\Repositorys\AlocacaoRepositoryContract;
use App\Modules\GestaoEquipe\DTOs\AlocacaoDTO;
use App\Modules\GestaoEquipe\Enums\PermissionEnum;
use App\System\Contracts\Business\EquipeBusinessContract;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Impl\BusinessAbstract;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\DataCollection;

class AlocacaoBusiness extends BusinessAbstract implements AlocacaoBusinessContract
{
    public function __construct(
        private readonly AlocacaoRepositoryContract $alocacaoRepository,
        private readonly EquipeBusinessContract $equipeBusiness
    )
    {

    }
    public function criarAlocacao(AlocacaoDTO $dados): AlocacaoDTO
    {
        // TODO: Implement criarAlocacao() method.
    }

    public function alterarAlocacao(int $id, AlocacaoDTO $dados): AlocacaoDTO
    {
        // TODO: Implement alterarAlocacao() method.
    }

    public function excluirAlocacao(int $id): bool
    {
        // TODO: Implement excluirAlocacao() method.
    }

    public function consultarAlocacao(int $id): DataCollection
    {
        // TODO: Implement consultarAlocacao() method.
    }

    public function listarAlocacoes(int $idEquipe): DataCollection
    {
        if(!$this->equipeBusiness->hasEquipe($idEquipe,Auth::user()->getAuthIdentifier())){
            throw new NotFoundException();
        }
        if($this->canDo(PermissionEnum::VER_ALOCACAO->value,'api')){
            return $this->alocacaoRepository->listarAlocacoes($idEquipe);
        }
        if($this->canDo(PermissionEnum::VER_MINHA_ALOCACAO->value, 'api')){
            return $this->alocacaoRepository->listarAlocacoes($idEquipe);
        }
        throw new UnauthorizedException(401, 'Sem permissão para acessar alocacoes');
    }
}
