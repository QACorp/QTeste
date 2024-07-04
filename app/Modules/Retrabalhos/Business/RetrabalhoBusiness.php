<?php

namespace App\Modules\Retrabalhos\Business;

use App\Modules\Projetos\Contracts\Business\CasoTesteBusinessContract;
use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\Enums\CasoTesteEnum;
use App\Modules\Retrabalhos\Contracts\Business\RetrabalhoBusinessContract;
use App\Modules\Retrabalhos\Contracts\Business\TipoRetrabalhoBusinessContract;
use App\Modules\Retrabalhos\Contracts\Repositorys\RetrabalhoRepositoryContract;
use App\Modules\Retrabalhos\DTOs\RetrabalhoCasoTesteDTO;
use App\Modules\Retrabalhos\Enums\PermissionEnum;
use App\Modules\Retrabalhos\Enums\TipoRetrabalhoEnum;
use App\Modules\Retrabalhos\Mails\CadastroRetrabalho;
use App\Modules\Retrabalhos\Rules\IdCasoTesteOuCasoTesteRule;
use App\System\Contracts\Business\UserBusinessContract;
use App\System\DTOs\EquipeDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Impl\BusinessAbstract;
use App\System\Services\Mail\DTOs\MailDTO;
use App\System\Services\Mail\QTesteMail;
use App\System\Traits\Configuracao;
use App\System\Traits\TransactionDatabase;
use App\System\Traits\Validation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Spatie\LaravelData\DataCollection;

class RetrabalhoBusiness extends BusinessAbstract implements RetrabalhoBusinessContract
{
    use TransactionDatabase, Configuracao;
    public function __construct(
        private readonly RetrabalhoRepositoryContract $retrabalhoRepository,
        private readonly TipoRetrabalhoBusinessContract $tipoRetrabalhoBusiness,
        private readonly CasoTesteBusinessContract $casoTesteBusiness,
        private readonly UserBusinessContract $userBusiness
    )
    {
    }

    public function salvar(RetrabalhoCasoTesteDTO $retrabalhoCasoTesteDTO, int $idEquipe): RetrabalhoCasoTesteDTO
    {
        $this->can(PermissionEnum::INSERIR_RETRABALHO->value);
        $tipoRetrabalho = $this->tipoRetrabalhoBusiness->getTipoRetrabalhoPorId($retrabalhoCasoTesteDTO->tipo_retrabalho_id);
        if(!$tipoRetrabalho){
            throw new NotFoundException("Tipo de retrabalho não encontrado.");
        }
        $this->startTransaction();
        if($tipoRetrabalho->tipo->value == TipoRetrabalhoEnum::FUNCIONAL->value) {
            $casoTeste = $this->inserirCasoTeste($retrabalhoCasoTesteDTO, $idEquipe);
            if ($casoTeste) {
                $retrabalhoCasoTesteDTO->caso_teste_id = $casoTeste->id;
            } else {
                $casoTeste = $this->casoTesteBusiness->buscarCasoTestePorId($retrabalhoCasoTesteDTO->caso_teste_id, $idEquipe);
                if (!$casoTeste) {
                    $this->rollback();
                    throw new NotFoundException("Caso de teste não encontrado.");
                }
            }
        }
        $retrabalho =  $this->retrabalhoRepository->salvar($retrabalhoCasoTesteDTO);
        $this->commit();
        $this->configureMail();
        if($this->buscarConfiguracao('core','SEND_MAIL_ENABLE')->valor == 'true'){
            Mail::to($this->userBusiness->buscarPorId($retrabalho->usuario_id)->email)
                ->send(new CadastroRetrabalho($retrabalho));
        }

        return $retrabalho;

    }
    public function inserirCasoTeste(RetrabalhoCasoTesteDTO $retrabalhoCasoTesteDTO, int $idEquipe): ?CasoTesteDTO
    {
        if (!$retrabalhoCasoTesteDTO->caso_teste_id) {
            $casoTesteDTO = CasoTesteDTO::from([
                'titulo' => $retrabalhoCasoTesteDTO->titulo_caso_teste,
                'requisito' => $retrabalhoCasoTesteDTO->requisito_caso_teste,
                'cenario' => $retrabalhoCasoTesteDTO->cenario_caso_teste,
                'teste' => $retrabalhoCasoTesteDTO->teste_caso_teste,
                'resultado_esperado' => $retrabalhoCasoTesteDTO->resultado_esperado_caso_teste,
                'status' => CasoTesteEnum::CONCLUIDO->value,
                'equipes' => EquipeDTO::collection([['id' => $idEquipe]])

            ]);
            $casoTesteDTO = $this->casoTesteBusiness->inserirCasoTeste($casoTesteDTO, $idEquipe);
            return $casoTesteDTO;
        }
        return null;
    }
    public function buscarPorId(int $idRetrabalho, ?int $idUsuario): ?RetrabalhoCasoTesteDTO
    {
        $this->can(PermissionEnum::LISTAR_RETRABALHO->value);
        $retrabalho = $this->retrabalhoRepository->buscarPorId($idRetrabalho);
        if(!$retrabalho){
            throw new NotFoundException("Retrabalho não encontrado.");
        }

        if(!$this->canDo(PermissionEnum::VER_TODOS_RETRABALHOS->value) &&
            $retrabalho->usuario_id != $idUsuario &&
            $retrabalho->usuario_criador_id != $idUsuario)
        {
            throw new NotFoundException("Retrabalho não encontrado.");
        }
        return $retrabalho;
    }

    public function buscarTodosPorEquipe(int $idEquipe): DataCollection
    {
        $this->can(PermissionEnum::VER_TODOS_RETRABALHOS->value);
        return $this->retrabalhoRepository->buscarTodosPorEquipe($idEquipe);
    }

    public function buscarTodosPorUsuario(int $idUsuario): DataCollection
    {
        $this->can(PermissionEnum::LISTAR_RETRABALHO->value);
        return $this->retrabalhoRepository->buscarTodosPorUsuario($idUsuario);
    }

    public function buscarRetrabalho(int $idEquipe, int $idUsuario): DataCollection
    {

        if($this->canDo(PermissionEnum::VER_TODOS_RETRABALHOS->value)){
            return $this->buscarTodosPorEquipe($idEquipe);
        }
        $this->can(PermissionEnum::LISTAR_RETRABALHO->value);
        return $this->buscarTodosPorUsuario($idUsuario);
    }

    public function canAlterarRetrabalho(RetrabalhoCasoTesteDTO $retrabalhoDTO, int $idUsuario): bool
    {
        if($this->canDo(PermissionEnum::ALTERAR_TODOS_RETRABALHOS->value)){
            return true;
        }
        if($this->canDo(PermissionEnum::ALTERAR_RETRABALHO->value)){
            return $retrabalhoDTO->usuario_criador_id == $idUsuario;
        }

        return false;

    }
    public function canRemoverRetrabalho(RetrabalhoCasoTesteDTO $retrabalhoDTO, int $idUsuario): bool
    {
        if($this->canDo(PermissionEnum::REMOVER_TODOS_RETRABALHOS->value)){
            return true;
        }
        if($this->canDo(PermissionEnum::REMOVER_RETRABALHO->value)){
            return $retrabalhoDTO->usuario_criador_id == $idUsuario;
        }
        return false;
    }

    public function canVerRetrabalho(RetrabalhoCasoTesteDTO $retrabalhoDTO, int $idUsuario): bool
    {
        if($this->canDo(PermissionEnum::VER_TODOS_RETRABALHOS->value)){
            return true;
        }
        return $retrabalhoDTO->usuario_criador_id == $idUsuario || $retrabalhoDTO->usuario_id == $idUsuario;
    }

    public function remover(int $idRetrabalho, ?int $idUsuario): bool
    {
        $retrabalho = $this->retrabalhoRepository->buscarPorId($idRetrabalho);
        if(!$retrabalho){
            throw new NotFoundException('Retrabalho não encontrado');
        }
        if($this->canRemoverRetrabalho($retrabalho, $idUsuario)){
            return $this->retrabalhoRepository->remover($retrabalho->id);
        }
        throw new UnauthorizedException();
    }

    public function editar(RetrabalhoCasoTesteDTO $retrabalhoCasoTesteDTO, int $idUsuario, int $idEquipe): RetrabalhoCasoTesteDTO
    {
        $tipoRetrabalho = $this->tipoRetrabalhoBusiness->getTipoRetrabalhoPorId($retrabalhoCasoTesteDTO->tipo_retrabalho_id);
        if(!$tipoRetrabalho){
            throw new NotFoundException("Tipo de retrabalho não encontrado.");
        }
        $retrabalho = $this->retrabalhoRepository->buscarPorId($retrabalhoCasoTesteDTO->id);
        if(!$this->canAlterarRetrabalho($retrabalho,$idUsuario)){
            throw new UnauthorizedException('Acesso negado');
        }
        $retrabalhoCasoTesteDTO->usuario_criador_id = $retrabalho->usuario_criador_id;
        if($tipoRetrabalho->tipo->value == TipoRetrabalhoEnum::FUNCIONAL->value) {
            $this->startTransaction();
            $casoTeste = $this->inserirOuBuscar($retrabalhoCasoTesteDTO, $idEquipe);
            $retrabalhoCasoTesteDTO->caso_teste_id = $casoTeste->id;
        }
        $this->commit();
        return $this->retrabalhoRepository->editar($retrabalhoCasoTesteDTO);


    }
    private function inserirOuBuscar(RetrabalhoCasoTesteDTO $retrabalhoCasoTesteDTO, int $idEquipe): CasoTesteDTO
    {
        $casoTeste = $this->inserirCasoTeste($retrabalhoCasoTesteDTO, $idEquipe);
        if (!$casoTeste) {
            $casoTeste = $this->casoTesteBusiness->buscarCasoTestePorId($retrabalhoCasoTesteDTO->caso_teste_id, $idEquipe);
        }
        if (!$casoTeste) {
            $this->rollback();
            throw new NotFoundException("Caso de teste não encontrado.");
        }
        return $casoTeste;
    }

    public function buscarRetrabalhoPorCasoTeste(CasoTesteDTO $casoTesteDTO): DataCollection
    {
        return $this->retrabalhoRepository->buscarRetrabalhoPorCasoTeste($casoTesteDTO);
    }
}
