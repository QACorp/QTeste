<?php

namespace App\Modules\Retrabalhos\Models;


use App\Modules\Retrabalhos\Enums\TipoRetrabalhoEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoRetrabalho extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'projetos.tipos_retrabalhos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'descricao',
        'tipo'
    ];
    protected $casts = [
        'tipo' => TipoRetrabalhoEnum::class
    ];
    public function retrabalhos()
    {
        return $this->hasMany(Retrabalho::class, 'tipo_retrabalho_id');
    }
}
