<?php

namespace App\System\Contracts\Business;

use App\System\DTOs\EmpresaConfiguracaoDTO;
use App\System\Requests\ConfiguracaoRequest;

interface CoreConfiguracaoBusinessContract
{
    public function salvarConfiguracaoCore(ConfiguracaoRequest $configuracaoRequest):bool;
}
