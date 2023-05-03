<?php

namespace App\Modules\Projetos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanoTesteExecucao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'projetos.plano_teste_execucoes';
    protected $fillable = [
        'resultado',
        'user_id',
        'data_execucao',
        'caso_teste_plano_teste_id'
    ];

    public function casos_teste()
    {
        return $this->hasMany(CasoTestePlanoTeste::class);

    }
}
