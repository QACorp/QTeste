<?php

namespace App\Modules\Retrabalhos\Contracts\Repositorys;

use Spatie\LaravelData\DataCollection;

interface TipoRetrabalhoRepositoryContract
{
    public function listaTipoRetrabalho():DataCollection;
}
