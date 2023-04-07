<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\AplicacaoBusinessContract;
use App\Modules\Projetos\Contracts\AplicacaoRepositoryContract;
use App\Modules\Projetos\DTOs\AplicacaoDTO;
use App\Modules\Projetos\Models\Aplicacao;
use Spatie\LaravelData\DataCollection;

class AplicacaoBusiness implements AplicacaoBusinessContract
{
    public function __construct(
        private readonly AplicacaoRepositoryContract $aplicacaoRepository
    )
    {
    }

    public function buscarTodos(): DataCollection
    {
        return  $this->aplicacaoRepository->buscarTodos();
    }

    public function salvar(AplicacaoDTO $aplicacaoDTO): AplicacaoDTO
    {
        return $this->aplicacaoRepository->salvar($aplicacaoDTO);
    }
}
