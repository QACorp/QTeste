<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\CasoTesteRespositoryContract;
use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use App\Modules\Projetos\Models\CasoTeste;
use App\Modules\Projetos\Models\PlanoTeste;
use Spatie\LaravelData\DataCollection;

class CasoTesteRepository implements CasoTesteRespositoryContract
{

    public function buscarCasoTestePorPlanoTeste(int $idPlanoTeste): ?DataCollection
    {
        return CasoTesteDTO::collection(
            PlanoTeste::find($idPlanoTeste)
                ->casos_teste()
                ->where('projetos.caso_teste_plano_teste.deleted_at', null)
                ->get()
        );
    }

    public function buscarCasoTestePorString(string $term): ?DataCollection
    {
        return CasoTesteDTO::collection(
            CasoTeste::where('titulo','ILIKE','%'.$term.'%')
                ->orWhere('requisito','ILIKE','%'.$term.'%')
                ->get()
        );
    }

    public function vincular(int $idPlanoTeste, CasoTesteDTO $casoTesteDTO): PlanoTesteDTO
    {

        $planoTeste = PlanoTeste::find($idPlanoTeste);
        $casoTeste = CasoTeste::find($casoTesteDTO->id);
        $planoTeste->casos_teste()->attach($casoTeste);
        $planoTeste->save();
        return PlanoTesteDTO::from($planoTeste);
    }
    public function desvincular(int $idPlanoTeste, int $idCasoTeste): PlanoTesteDTO
    {

        $planoTeste = PlanoTeste::find($idPlanoTeste);
        $planoTeste->casos_teste()->detach($idCasoTeste);
        $planoTeste->save();
        return PlanoTesteDTO::from($planoTeste);
    }
    public function existeVinculo(int $idPlanoTeste, int $idCasoTeste): bool
    {
        $planoTeste = PlanoTeste::find($idPlanoTeste);
        $existe = $planoTeste->casos_teste()->where('caso_teste_id', $idCasoTeste)->count();

        return $existe > 0;
    }

    public function existeCasoTeste(int $idCasoTeste): bool
    {
        return CasoTeste::find($idCasoTeste) != null;
    }

    public function inserirCasoTeste(CasoTesteDTO $casoTesteDTO): CasoTesteDTO
    {
        $casoTeste = new CasoTeste($casoTesteDTO->toArray());
        $casoTeste->save();
        return CasoTesteDTO::from($casoTeste);
    }
}
