<?php

namespace App\System\Contracts\Repository;

use App\System\DTOs\EmpresaDTO;

interface EmpresaRepositoryContract
{
    public function salvar(EmpresaDTO $data): EmpresaDTO;
}
