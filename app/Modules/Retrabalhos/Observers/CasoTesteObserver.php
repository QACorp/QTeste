<?php

namespace App\Modules\Retrabalhos\Observers;


use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\Models\CasoTeste;
use App\Modules\Retrabalhos\Contracts\Business\RetrabalhoBusinessContract;
use App\System\Exceptions\ConflictException;

class CasoTesteObserver
{
    public function __construct(
        private readonly RetrabalhoBusinessContract $retrabalhoBusiness
    )
    {
    }


    public function deleting(CasoTeste $casoTeste): void
    {
        $existeRetrabalho = $this->retrabalhoBusiness->buscarRetrabalhoPorCasoTeste(CasoTesteDTO::from($casoTeste))->count() > 0;
        if($existeRetrabalho){
            throw new ConflictException("Não é possível excluir um caso de teste que está vinculado a um retrabalho.");
        }
    }

}
