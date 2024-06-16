<?php

namespace App\System\Contracts\Business;

use App\System\DTOs\EmpresaDTO;
use App\System\DTOs\EquipeDTO;
use App\System\Requests\EquipePostRequest;
use Spatie\LaravelData\DataCollection;

interface EmpresaBusinessContract
{
    public function salvar(EmpresaDTO $data): EmpresaDTO;
}
