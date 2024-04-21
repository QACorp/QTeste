<?php

namespace App\Modules\Retrabalhos\Models;
use App\System\Models\User as BaseModel;
class User extends BaseModel
{
    public function retrabalhos()
    {
        return $this->hasMany(Retrabalho::class, 'id_usuario');
    }
    public function retrabalhosCriador()
    {
        return $this->hasMany(Retrabalho::class, 'id_usuario_criador');
    }
}
