<?php

namespace App\Modules\GestaoEquipe\Repositorys;

use App\Modules\GestaoEquipe\Contracts\Repositorys\ProjetoRepositoryContract;
use App\Modules\Projetos\DTOs\ProjetoDTO;
use App\Modules\Projetos\Models\Projeto;
use App\Modules\Projetos\Repositorys\ProjetoRepository as BaseProjetoRepository;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\DataCollection;

class ProjetoRepository extends BaseProjetoRepository implements ProjetoRepositoryContract
{

    public function buscarProjetosVigentes(int $equipeId, Carbon $dataInicio, Carbon $dataFim): DataCollection
    {
        $projetos = Projeto::where('equipe_id', $equipeId)
            ->whereBetween('inicio', [$dataInicio, $dataFim])
            ->orWhereBetween('termino', [$dataInicio, $dataFim])
            ->get();
        return ProjetoDTO::collection($projetos);

    }
}
