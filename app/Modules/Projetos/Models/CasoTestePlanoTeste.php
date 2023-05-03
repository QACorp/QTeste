<?php

namespace App\Modules\Projetos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CasoTestePlanoTeste extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'projetos.caso_teste_plano_teste';
    public function plano_teste_execucoes()
    {
        return $this->belongsTo(PlanoTesteExecucao::class);

    }
}
