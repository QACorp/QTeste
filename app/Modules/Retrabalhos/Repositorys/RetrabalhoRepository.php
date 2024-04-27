<?php

namespace App\Modules\Retrabalhos\Repositorys;

use App\Modules\Retrabalhos\Contracts\Repositorys\RetrabalhoRepositoryContract;
use App\Modules\Retrabalhos\DTOs\RetrabalhoCasoTesteDTO;
use App\Modules\Retrabalhos\Models\Retrabalho;

class RetrabalhoRepository implements RetrabalhoRepositoryContract
{

    public function salvar(RetrabalhoCasoTesteDTO $retrabalhoCasoTesteDTO): RetrabalhoCasoTesteDTO
    {
        $retrabalho = new Retrabalho($retrabalhoCasoTesteDTO->toArray());
        $retrabalho->save();
        $retrabalho->refresh();
        $retrabalho->load(['caso_teste', 'aplicacao', 'tipo_retrabalho', 'projeto', 'usuario']);
        //$retrabalho = $retrabalho->with(['caso_teste', 'aplicacao', 'tipo_retrabalho', 'projeto', 'usuario']);
        return RetrabalhoCasoTesteDTO::from($retrabalho);
    }

    public function buscarPorId(int $idRetrabalho): ?RetrabalhoCasoTesteDTO
    {
        $retrabalho = Retrabalho::with(['caso_teste', 'aplicacao', 'tipo_retrabalho', 'projeto', 'usuario'])->find($idRetrabalho);
        return $retrabalho ? RetrabalhoCasoTesteDTO::from($retrabalho) : null;
    }
}
