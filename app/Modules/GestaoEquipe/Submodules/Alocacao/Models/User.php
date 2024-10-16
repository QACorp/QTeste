<?php

namespace App\Modules\GestaoEquipe\Submodules\Alocacao\Models;


use App\Modules\GestaoEquipe\Submodules\Alocacao\Models\Alocacao;
use App\System\Models\User as BaseUser;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends BaseUser
{

    public function alocacoes(): HasMany
    {
        return $this->hasMany(Alocacao::class);
    }

}
