<?php

namespace App\Modules\Retrabalhos\Contracts\Business;

use App\Modules\Retrabalhos\DTOs\TipoRetrabalhoDTO;
use Spatie\LaravelData\DataCollection;

interface TipoRetrabalhoBusinessContract
{
    public function listaTipoRetrabalho():DataCollection;
    public function getTipoRetrabalhoPorId(int $id):TipoRetrabalhoDTO;
}
