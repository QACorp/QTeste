<?php

namespace App\Modules\Retrabalhos\Models;
use App\System\Models\User as BaseModel;
class User extends BaseModel
{
    public function integracao()
    {
        return $this->hasOne(IntegracaoUsuario::class);
    }
}
