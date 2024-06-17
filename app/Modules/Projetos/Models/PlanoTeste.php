<?php

namespace App\Modules\Projetos\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class PlanoTeste extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'projetos.planos_teste';
    protected $casts = [
        'created_at' => 'datetime',
    ];
    protected $fillable = [
        'titulo',
        'descricao',
        'user_id',
        'projeto_id'
    ];

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);

    }

    public function casos_teste(): BelongsToMany
    {
        return $this->belongsToMany(CasoTeste::class, 'projetos.caso_teste_plano_teste')->using(CasoTestePlanoTeste::class);
    }

    public function execucao()
    {
        return $this->hasMany(PlanoTesteExecucao::class);

    }

    public function newQuery(): Builder
    {
        return parent::newQuery()
            ->addSelect('planos_teste.*')
            ->join('projetos.projetos','projetos.id','=','planos_teste.projeto_id')
            ->join('projetos.aplicacoes','aplicacoes.id','=','projetos.aplicacao_id')
            ->join('projetos.aplicacoes_equipes','aplicacoes.id','=','aplicacoes_equipes.aplicacao_id')
            ->join('equipes','equipes.id','=','aplicacoes_equipes.equipe_id')
            ->where('equipes.empresa_id', Auth::user()->empresa_id);
    }
}
