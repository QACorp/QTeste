<?php

namespace App\Modules\Retrabalhos\Repositorys;

use App\Modules\Retrabalhos\Contracts\Repositorys\RetrabalhoRepositoryContract;
use App\Modules\Retrabalhos\Contracts\Repositorys\TipoRetrabalhoRepositoryContract;
use App\Modules\Retrabalhos\DTOs\TipoRetrabalhoDTO;
use App\Modules\Retrabalhos\Models\TipoRetrabalho;
use Spatie\LaravelData\DataCollection;

class TipoRetrabalhoRepository implements TipoRetrabalhoRepositoryContract
{
    public function listaTipoRetrabalho(): DataCollection
    {
        return TipoRetrabalhoDTO::collection(TipoRetrabalho::orderBy('descricao')->get());
    }

    public function getTipoRetrabalhoPorId(int $id): ?TipoRetrabalhoDTO
    {
        $tipoRetrabalho = TipoRetrabalho::find($id);
        return $tipoRetrabalho ? TipoRetrabalhoDTO::from($tipoRetrabalho): null;
    }

    public function createTipoRetrabalho(TipoRetrabalhoDTO $tipoRetrabalhoDTO): TipoRetrabalhoDTO
    {
        $tipoRetrabalho = new TipoRetrabalho($tipoRetrabalhoDTO->all());
        $tipoRetrabalho->save();
        return TipoRetrabalhoDTO::from($tipoRetrabalho);
    }
}
