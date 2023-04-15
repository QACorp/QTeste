<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\AplicacaoBusinessContract;
use App\Modules\Projetos\Contracts\ProjetoBusinessContract;
use App\Modules\Projetos\Contracts\ProjetoRepositoryContract;
use App\Modules\Projetos\Repositorys\ProjetoRepository;
use App\System\Exceptions\NotFoundException;
use Spatie\LaravelData\DataCollection;

class ProjetoBusiness implements ProjetoBusinessContract
{
    public function __construct(
        private readonly ProjetoRepositoryContract $projetoRepository,
        private readonly AplicacaoBusinessContract $aplicacaoBusiness
    )
    {
    }

    public function buscarTodosPorAplicacao(int $aplicacaoId): DataCollection
    {
        try {
            $this->aplicacaoBusiness->buscarPorId($aplicacaoId);
            return $this->projetoRepository->buscarTodosPorAplicacao($aplicacaoId);
        }catch (NotFoundException $exception){
            throw $exception;
        }

    }
}
