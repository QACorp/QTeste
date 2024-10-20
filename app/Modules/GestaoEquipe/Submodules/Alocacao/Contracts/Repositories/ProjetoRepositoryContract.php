<?php

namespace App\Modules\GestaoEquipe\Submodules\Alocacao\Contracts\Repositories;

use App\Modules\GestaoEquipe\Submodules\Alocacao\DTOs\AlocacaoDTO;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\DataCollection;
use App\Modules\Projetos\Contracts\Repository\ProjetoRepositoryContract as BaseProjetoRepositoryContract;

interface ProjetoRepositoryContract extends BaseProjetoRepositoryContract
{
    public function buscarProjetosVigentes(int $equipeId, Carbon $dataInicio, Carbon $dataFim): DataCollection;
}
