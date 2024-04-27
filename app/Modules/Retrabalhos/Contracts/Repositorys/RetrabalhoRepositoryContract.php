<?php

namespace App\Modules\Retrabalhos\Contracts\Repositorys;

use App\Modules\Retrabalhos\DTOs\RetrabalhoCasoTesteDTO;

interface RetrabalhoRepositoryContract
{
    public function salvar(RetrabalhoCasoTesteDTO $retrabalhoCasoTesteDTO): RetrabalhoCasoTesteDTO;
    public function buscarPorId(int $idRetrabalho): ?RetrabalhoCasoTesteDTO;
}
