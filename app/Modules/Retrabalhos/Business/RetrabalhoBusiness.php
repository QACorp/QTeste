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
use App\Modules\Retrabalhos\Rules\IdCasoTesteOuCasoTesteRule;
use App\System\DTOs\EquipeDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Impl\BusinessAbstract;
use App\System\Traits\TransactionDatabase;
use App\System\Traits\Validation;
use Illuminate\Support\Facades\App;
use Spatie\LaravelData\DataCollection;

class RetrabalhoBusiness extends BusinessAbstract implements RetrabalhoBusinessContract
{
    use TransactionDatabase;
    public function __construct(
        private readonly RetrabalhoRepositoryContract $retrabalhoRepository,
        private readonly TipoRetrabalhoBusinessContract $tipoRetrabalhoBusiness,
        private readonly CasoTesteBusinessContract $casoTesteBusiness
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
        if(!$retrabalhoCasoTesteDTO->caso_teste_id){
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
            $retrabalhoCasoTesteDTO->caso_teste_id = $casoTesteDTO->id;
        }else{
            $casoTeste = $this->casoTesteBusiness->buscarCasoTestePorId($retrabalhoCasoTesteDTO->caso_teste_id, $idEquipe);
            if(!$casoTeste){
                throw new NotFoundException("Caso de teste não encontrado.");
            }
        }


        $retrabalho =  $this->retrabalhoRepository->salvar($retrabalhoCasoTesteDTO);
        $this->commit();
        return $retrabalho;

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
        // TODO: Implement buscarTodosPorUsuario() method.
    }

    public function buscarRetrabalho(int $idEquipe, int $idUsuario): DataCollection
    {

        if($this->canDo(PermissionEnum::VER_TODOS_RETRABALHOS->value)){
            return $this->buscarTodosPorEquipe($idEquipe);
        }
        $this->can(PermissionEnum::LISTAR_RETRABALHO->value);
        return $this->buscarTodosPorUsuario($idUsuario);
    }
}
