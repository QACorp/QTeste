<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\PlanoTesteRepositoryContract;
use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use App\Modules\Projetos\Models\PlanoTeste;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class PlanoTesteRepository implements PlanoTesteRepositoryContract
{

    public function buscarPlanosTestePorProjeto(int $idProjeto): DataCollection
    {
        return PlanoTesteDTO::collection(
            PlanoTeste::where('projeto_id',$idProjeto)->get()
        );
    }

    public function salvarPlanoTeste(PlanoTesteDTO $planoTesteDTO): PlanoTesteDTO
    {
        $planoTeste = new PlanoTeste($planoTesteDTO->toArray());
        $planoTeste->save();
        return PlanoTesteDTO::from($planoTeste);
    }

    public function excluirPlanoTeste(int $idPlanoTeste): bool
    {
        $planoTeste = PlanoTeste::find($idPlanoTeste);
        return $planoTeste->delete();
    }

    public function buscarPlanoTestePorId(int $idPlanoTeste): ?PlanoTesteDTO
    {
        $planoTeste = PlanoTeste::find($idPlanoTeste);
        return $planoTeste == null ? null : PlanoTesteDTO::from($planoTeste);
    }

    public function alterarPlanoTeste(PlanoTesteDTO $planoTesteDTO): PlanoTesteDTO
    {
        $planoTeste = PlanoTeste::find($planoTesteDTO->id);
        $planoTeste->titulo = $planoTesteDTO->titulo;
        $planoTeste->descricao = $planoTesteDTO->descricao;
        $planoTeste->update();
        return PlanoTesteDTO::from($planoTeste);
    }

    public function buscarTodosPlanoTeste(): DataCollection
    {
        return PlanoTesteDTO::collection(PlanoTeste::with('projeto')->get());
    }
}
