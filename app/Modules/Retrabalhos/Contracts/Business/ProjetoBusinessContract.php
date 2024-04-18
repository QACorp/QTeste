<?php

namespace App\Modules\Retrabalhos\Contracts\Business;

use App\Modules\Retrabalhos\DTOs\ProjetoDTO;
use App\Modules\Projetos\Contracts\Business\ProjetoBusinessContract as BaseBusinessContract;

interface ProjetoBusinessContract extends BaseBusinessContract
{
    public function buscarPorIdProjeto(int $idProjeto, int $idEquipe): ?ProjetoDTO;
}
