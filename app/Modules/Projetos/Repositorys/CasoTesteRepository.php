<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\Repository\CasoTesteRepositoryContract;
use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use App\Modules\Projetos\Enums\CasoTesteEnum;
use App\Modules\Projetos\Models\CasoTeste;
use App\Modules\Projetos\Models\PlanoTeste;
use App\System\DTOs\EquipeDTO;
use App\System\Exceptions\ConflictException;
use App\System\Impl\BaseRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class CasoTesteRepository extends BaseRepository  implements CasoTesteRepositoryContract
{

    public function buscarCasoTestePorPlanoTeste(int $idPlanoTeste, int $idEquipe): ?DataCollection
    {
        return CasoTesteDTO::collection(
            PlanoTeste::find($idPlanoTeste)
                ->casos_teste()
                ->where('equipe_id',$idEquipe)
                ->where('projetos.caso_teste_plano_teste.deleted_at', null)
                ->get()
        );
    }

    public function buscarCasoTestePorString(string $term, int $idEquipe): ?DataCollection
    {

        return CasoTesteDTO::collection(
            CasoTeste::select('casos_teste.*')
                ->where('status', CasoTesteEnum::CONCLUIDO->value)
                ->where('equipe_id', $idEquipe)
                ->where(function($query) use($term){
                    $query->where('titulo','ILIKE','%'.$term.'%')
                        ->orWhere('requisito','ILIKE','%'.$term.'%');
                })
                ->get()
        );
    }

    public function vincular(int $idPlanoTeste, int $idEquipe, CasoTesteDTO $casoTesteDTO): PlanoTesteDTO
    {

        $planoTeste = PlanoTeste::find($idPlanoTeste);
        $casoTeste = CasoTeste::find($casoTesteDTO->id);
        $planoTeste->casos_teste()->attach($casoTeste);
        $planoTeste->save();
        return PlanoTesteDTO::from($planoTeste);
    }
    public function desvincular(int $idPlanoTeste, int $idEquipe, int $idCasoTeste): PlanoTesteDTO
    {

        $planoTeste = PlanoTeste::find($idPlanoTeste);
        $planoTeste->casos_teste()->detach($idCasoTeste);
        $planoTeste->save();
        return PlanoTesteDTO::from($planoTeste);
    }
    public function existeVinculo(int $idPlanoTeste, int $idCasoTeste, int $idEquipe): bool
    {
        $planoTeste = PlanoTeste::find($idPlanoTeste);
        $existe = $planoTeste->casos_teste()
                            ->where('equipe_id', $idEquipe)
                            ->where('casos_teste.id', $idCasoTeste)
                            ->count();

        return $existe > 0;
    }

    public function existeCasoTeste(int $idCasoTeste, int $idEquipe): bool
    {
        return  CasoTeste::select('casos_teste.*')
                ->where('equipe_id',$idEquipe)
                ->where('casos_teste.id', $idCasoTeste)
                ->first() != null;
    }
    public function inserirCasoTeste(CasoTesteDTO $casoTesteDTO): CasoTesteDTO
    {
        DB::beginTransaction();
        try {
            $casoTeste = new CasoTeste($casoTesteDTO->toArray());
            $casoTeste->save();
            $casoTeste = $this->atualizarCasoTesteEquipe($casoTesteDTO, $casoTeste);
            DB::commit();
            return CasoTesteDTO::from($casoTeste);
        }catch (Exception $exception){
            DB::rollBack();
            throw $exception;
        }
    }
    private function atualizarCasoTesteEquipe(CasoTesteDTO $casoTesteDTO, CasoTeste $casoTeste):CasoTeste
    {
        $casoTesteDTO->equipes->each(function ($item, $key) use ($casoTeste, &$idsEquipe) {
            $idsEquipe[] = $item->id;
        });
        $casoTeste->equipes()->sync($idsEquipe);
        return $casoTeste;
    }
    public function buscarTodos(int $idEquipe): DataCollection
    {
        return CasoTesteDTO::collection(
            CasoTeste::where('casos_teste_equipes.equipe_id',$idEquipe)
                ->get()
        );
    }
    public function excluir(int $idCasoTeste): bool
    {
        try {
            return CasoTeste::find($idCasoTeste)->delete();
        }catch (ConflictException $exception){
            throw $exception;
        }
    }

    public function buscarCasoTestePorId(int $idCasoTeste, int $idEquipe): ?CasoTesteDTO
    {
        $casoTeste = CasoTeste::where('casos_teste_equipes.equipe_id',$idEquipe)
            ->where('casos_teste.id', $idCasoTeste)
            ->first();
        if($casoTeste != null){
            $casoTesteDTO = CasoTesteDTO::from($casoTeste);
            $casoTesteDTO->equipes = EquipeDTO::collection($casoTeste->equipes);
            return $casoTesteDTO;
        }
        return null;
    }

    public function alterarCasoTeste(CasoTesteDTO $casoTesteDTO): CasoTesteDTO
    {
        try {
            DB::beginTransaction();
            $casoTeste = CasoTeste::find($casoTesteDTO->id);
            $casoTeste->fill($casoTesteDTO->toArray());
            $casoTeste->update();
            $casoTeste = $this->atualizarCasoTesteEquipe($casoTesteDTO, $casoTeste);
            DB::commit();
            return CasoTesteDTO::from($casoTeste);
        }catch (Exception $exception){
            DB::rollBack();
            throw $exception;
        }

    }

}
