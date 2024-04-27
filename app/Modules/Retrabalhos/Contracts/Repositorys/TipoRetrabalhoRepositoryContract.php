<?php

namespace App\Modules\Retrabalhos\Contracts\Repositorys;

use App\Modules\Retrabalhos\DTOs\TipoRetrabalhoDTO;
use Spatie\LaravelData\DataCollection;

interface TipoRetrabalhoRepositoryContract
{
    public function listaTipoRetrabalho():DataCollection;
    public function getTipoRetrabalhoPorId(int $id): ?TipoRetrabalhoDTO;
}
