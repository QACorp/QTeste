<?php

namespace App\Modules\GestaoEquipe\Submodules\Alocacao\Business;

use App\Modules\GestaoEquipe\Submodules\Alocacao\Contracts\Business\AlocacaoBusinessContract;
use App\Modules\GestaoEquipe\Submodules\Alocacao\Contracts\Repositories\AlocacaoRepositoryContract;
use App\Modules\GestaoEquipe\Submodules\Alocacao\Contracts\Repositories\ProjetoRepositoryContract;
use App\Modules\GestaoEquipe\Submodules\Alocacao\DTOs\AlocacaoDTO;
use App\Modules\GestaoEquipe\Submodules\Alocacao\DTOs\FiltroConsultaAlocacaoDTO;
use App\Modules\GestaoEquipe\Submodules\Alocacao\Enums\NaturezaEnum;
use App\Modules\GestaoEquipe\Submodules\Alocacao\Enums\PermissionEnum;
use App\System\Contracts\Business\EquipeBusinessContract;
use App\System\Exceptions\ConflictException;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Impl\BusinessAbstract;
use App\System\Utils\EquipeUtils;
use App\System\Utils\RequestGuard;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\DataCollection;

class AlocacaoBusiness extends BusinessAbstract implements AlocacaoBusinessContract
{
    public function __construct(
        private readonly AlocacaoRepositoryContract $alocacaoRepository,
        private readonly EquipeBusinessContract $equipeBusiness,
        private readonly ProjetoRepositoryContract $projetoRepository
    )
    {

    }
    public function criarAlocacao(AlocacaoDTO $dados): AlocacaoDTO
    {
        $this->can(PermissionEnum::CRIAR_ALOCACAO->value, 'api');
        if(
            !$this->equipeBusiness->hasEquipe($dados->equipe_id, Auth::user()->getAuthIdentifier()) &&
            !$this->equipeBusiness->hasEquipe($dados->equipe_id, $dados->user_id)){
            throw new NotFoundException();
        }
        if($this->alocacaoRepository->hasAlocacaoInDate($dados->user_id, $dados->equipe_id, $dados->inicio, $dados->termino))
        {
            throw new ConflictException( 'Já existe uma alocação nesse período para este usuário',409);
        }
        return $this->alocacaoRepository->criarAlocacao($dados);
    }

    public function alterarAlocacao(int $id, AlocacaoDTO $dados): AlocacaoDTO
    {
        $this->can(PermissionEnum::EDITAR_ALOCACAO->value, 'api');

        $alocacao = $this->alocacaoRepository->consultarAlocacao($id, EquipeUtils::getEquipeUsuarioLogado('api'));
        if(!$this->isEquipeCriadora($alocacao->equipe_id)){
            throw new UnauthorizedException(401, 'Sem permissão para alterar alocacao');
        }
        if(!$this->equipeBusiness->hasEquipe($dados->equipe_id, $dados->user_id)){
            throw new NotFoundException();
        }

        if($alocacao->concluida || $alocacao->termino->isBefore(Carbon::create(date('Y-m-d')))){
            throw new ConflictException(' Alocação já concluída ou vencida', 409);
        }
        if( $this->hasAlteracao($dados, $alocacao) &&
            $this->alocacaoRepository->hasAlocacaoInDate($alocacao->user_id, $alocacao->equipe_id, $dados->inicio, $dados->termino, $alocacao->id))
        {
            throw new ConflictException( 'Já existe uma alocação nesse período para este usuário',409);
        }
        if($dados->natureza->value == NaturezaEnum::SUSTENTACAO->value){
            $dados->projeto_id = null;
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
        $this->can(PermissionEnum::VER_ALOCACAO->value, 'api');
        if(!$this->equipeBusiness->hasEquipe($idEquipe,Auth::user()->getAuthIdentifier())){
            throw new NotFoundException();
        }
        return $this->alocacaoRepository->consultarAlocacao($id, $idEquipe);
    }

    public function listarAlocacoes(int $idEquipe, FiltroConsultaAlocacaoDTO $filtro = null): DataCollection
    {

        if(!$this->equipeBusiness->hasEquipe($idEquipe,Auth::user()->getAuthIdentifier())){
            throw new NotFoundException();
        }
        if($this->canDo(PermissionEnum::VER_ALOCACAO->value,'api')){
            return $this->alocacaoRepository->listarAlocacoes($idEquipe, $filtro);
        }

        throw new UnauthorizedException(401, 'Sem permissão para acessar alocacoes');
    }

    public function usuariosDisponiveis(int $idEquipe, Carbon $inicio, Carbon $termino): DataCollection
    {
        if(!$this->equipeBusiness->hasEquipe($idEquipe,Auth::user()->getAuthIdentifier())){
            throw new NotFoundException();
        }
        return $this->alocacaoRepository->usuariosDisponiveis($idEquipe, $inicio, $termino);
    }
    public function buscarProjetosVigentes(int $equipeId, Carbon $dataInicio, Carbon $dataFim): DataCollection
    {
        if(!$this->equipeBusiness->hasEquipe($equipeId,Auth::user()->getAuthIdentifier())){
            throw new NotFoundException();
        }
        return $this->projetoRepository->buscarProjetosVigentes($equipeId, $dataInicio, $dataFim);
    }

    public function marcarAlocacaoComoConcluida(int $idAlocacao, int $idEquipe, Carbon $data): AlocacaoDTO
    {
        $this->can(PermissionEnum::CONCLUIR_ALOCACAO->value, 'api');
        $alocacao = $this->alocacaoRepository->consultarAlocacao($idAlocacao, $idEquipe);

        if(!$alocacao){
            throw new NotFoundException();
        }
        if($alocacao->concluida){
            throw new ConflictException('Alocação já concluída', 409);
        }
        if(!$this->isEquipeCriadora($alocacao->equipe_id)){
            throw new UnauthorizedException(401, 'Sem permissão para concluir alocação');
        }
        $alocacao->concluida = $data;
        return $this->alocacaoRepository->alterarAlocacao($idAlocacao, $alocacao);
    }

    public function listarMinhasAlocacoes(int $idEquipe, int $idUsuario): DataCollection
    {
        $this->can(PermissionEnum::VER_MINHA_ALOCACAO->value, 'api');
        if(!$this->equipeBusiness->hasEquipe($idEquipe,Auth::user()->getAuthIdentifier())){
            throw new NotFoundException();
        }
        return $this->alocacaoRepository->listarAlocacoesPorUsuario($idEquipe, $idUsuario);
    }
}
