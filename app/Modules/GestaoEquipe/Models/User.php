<?php

namespace App\Modules\GestaoEquipe\Models;


use App\System\Models\User as BaseUser;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends BaseUser
{

    public function alocacoes(): HasMany
    {
        return $this->hasMany(Alocacao::class);
    }

}
