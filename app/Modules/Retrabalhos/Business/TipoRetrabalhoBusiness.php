<?php

namespace App\Modules\Retrabalhos\Business;

use App\Modules\Retrabalhos\Contracts\Business\RetrabalhoBusinessContract;
use App\Modules\Retrabalhos\Contracts\Business\TipoRetrabalhoBusinessContract;
use App\Modules\Retrabalhos\Contracts\Repositorys\TipoRetrabalhoRepositoryContract;
use App\Modules\Retrabalhos\DTOs\TipoRetrabalhoDTO;
use App\System\Impl\BusinessAbstract;
use Spatie\LaravelData\DataCollection;

class TipoRetrabalhoBusiness extends BusinessAbstract implements TipoRetrabalhoBusinessContract
{
    public function __construct(private readonly TipoRetrabalhoRepositoryContract $tipoRetrabalhoRepository)
    {
    }

    public function listaTipoRetrabalho(): DataCollection
    {
        return $this->tipoRetrabalhoRepository->listaTipoRetrabalho();
    }

    public function getTipoRetrabalhoPorId(int $id): TipoRetrabalhoDTO
    {
        return $this->tipoRetrabalhoRepository->getTipoRetrabalhoPorId($id);
    }
}
