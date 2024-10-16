<?php

namespace App\Modules\GestaoEquipe\Submodules\Checkpoint\Repositories;


use App\Modules\GestaoEquipe\Submodules\Checkpoint\Contracts\Respositories\ProjetoRepositoryContract;
use App\Modules\GestaoEquipe\Submodules\Checkpoint\Models\Projeto;
use App\Modules\Projetos\DTOs\ProjetoDTO;
use App\Modules\Projetos\Repositorys\ProjetoRepository as BaseProjetoRepository;
use Carbon\Carbon;
use Spatie\LaravelData\DataCollection;

class ProjetoRepository extends BaseProjetoRepository implements ProjetoRepositoryContract
{


    public function getProjetos(int $idEquipe): DataCollection
    {
        $projetos = Projeto::where('equipe_id', $idEquipe)
                            ->where('termino','>=', Carbon::now())
                            ->get();
        return ProjetoDTO::collection($projetos);

    }
}
