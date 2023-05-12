<?php

namespace App\Modules\Projetos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CasoTeste extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'projetos.casos_teste';
    protected $fillable = [
        'titulo',
        'requisito',
        'cenario',
        'teste',
        'resultado_esperado',
        'status'
    ];

    public function planos_teste(): BelongsToMany
    {
        return $this->belongsToMany(PlanoTeste::class,'projetos.caso_teste_plano_teste')->using(CasoTestePlanoTeste::class);
    }
    public function execucao()
    {
        return $this->hasMany(CasoTesteExecucao::class);

    }
}
