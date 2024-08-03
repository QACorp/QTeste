<?php

namespace App\Modules\GestaoEquipe\Business;

use App\Modules\GestaoEquipe\Contracts\Business\AlocacaoBusinessContract;
use App\Modules\GestaoEquipe\Contracts\Repositorys\AlocacaoRepositoryContract;
use App\Modules\GestaoEquipe\DTOs\AlocacaoDTO;
use App\Modules\GestaoEquipe\Enums\PermissionEnum;
use App\System\Contracts\Business\EquipeBusinessContract;
use App\System\Exceptions\ConflictException;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Impl\BusinessAbstract;
use App\System\Utils\EquipeUtils;
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
        $this->can(PermissionEnum::EDITAR_ALOCACAO->value, 'api');

        $alocacao = $this->alocacaoRepository->consultarAlocacao($id, EquipeUtils::getEquipeUsuarioLogado('api'));
        if(!$this->isEquipeCriadora($alocacao->equipe_id)){
            throw new UnauthorizedException(401, 'Sem permissão para alterar alocacao');
        }
        if( $this->hasAlteracao($dados, $alocacao) &&
            $this->alocacaoRepository->hasAlocacaoInDate($alocacao->user_id, $alocacao->equipe_id, $dados->inicio, $dados->termino))
        {
            throw new ConflictException( 'Já existe uma alocação nesse período para este usuário',409);
        }
        return $this->alocacaoRepository->alterarAlocacao($id, $dados);
    }
    private function isEquipeCriadora(int $idEquipe): bool
    {
        return $idEquipe == EquipeUtils::getEquipeUsuarioLogado('api');
    }
    private function hasAlteracao(AlocacaoDTO $newAlocacao, AlocacaoDTO $oldAlocacao): bool
    {

        return $newAlocacao->inicio->format('d/m/Y') != $oldAlocacao->inicio->format('d/m/Y') || $newAlocacao->termino->format('d/m/Y') != $oldAlocacao->termino->format('d/m/Y')|| $newAlocacao->user_id != $oldAlocacao->user_id;
    }

    public function excluirAlocacao(int $id): bool
    {
        // TODO: Implement excluirAlocacao() method.
    }

    public function consultarAlocacao(int $id, int $idEquipe): ?AlocacaoDTO
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
