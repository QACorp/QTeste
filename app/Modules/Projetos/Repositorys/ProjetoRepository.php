<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\ProjetoRepositoryContract;
use App\Modules\Projetos\DTOs\ProjetoDTO;
use App\Modules\Projetos\Models\Aplicacao;
use Spatie\LaravelData\DataCollection;

class ProjetoRepository implements ProjetoRepositoryContract
{

    public function buscarTodosPorAplicacao(int $aplicacaoId): DataCollection
    {
        return ProjetoDTO::collection(
            Aplicacao::find($aplicacaoId)->projetos()->get()
        );
    }
}
