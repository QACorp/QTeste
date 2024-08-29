<?php

namespace App\Modules\GestaoEquipe\Alocacao\Repositories;

use App\Modules\GestaoEquipe\Alocacao\Contracts\Repositories\ProjetoRepositoryContract;
use App\Modules\Projetos\DTOs\ProjetoDTO;
use App\Modules\Projetos\Models\Projeto;
use App\Modules\Projetos\Repositorys\ProjetoRepository as BaseProjetoRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class ProjetoRepository extends BaseProjetoRepository implements ProjetoRepositoryContract
{

    public function buscarProjetosVigentes(int $equipeId, Carbon $dataInicio, Carbon $dataFim): DataCollection
    {
        $projetos = Projeto::where('equipe_id', $equipeId)
            ->where(function (Builder $query) use ($dataInicio, $dataFim) {
                $query->whereRaw("? BETWEEN inicio AND termino")
                    ->orWhereRaw("? BETWEEN inicio AND termino");
                $query->setBindings([
                    $dataInicio->format('Y-m-d'),
                    $dataFim->format('Y-m-d')
                ]);
            })

            ->with('aplicacao')

            ->get();
        return ProjetoDTO::collection($projetos);

    }
}
