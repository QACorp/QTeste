<?php

namespace App\Modules\Retrabalhos\Models;

use App\Modules\Projetos\Models\Projeto as BaseModel;

class Projeto extends BaseModel
{
    public function retrabalhos()
    {
        return $this->hasMany(Retrabalho::class, 'id_projeto');
    }
}
