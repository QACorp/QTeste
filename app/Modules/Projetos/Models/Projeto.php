<?php

namespace App\Modules\Projetos\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Projeto extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'projetos.projetos';
    protected $casts = [
        'inicio' => 'date',
        'termino' => 'date'
    ];
    protected $fillable = [
        'nome',
        'descricao',
        'inicio',
        'termino',
        'aplicacao_id'
    ];
    public function aplicacao()
    {
        return $this->belongsTo(Aplicacao::class);

    }
    public function observacoes()
    {
        return $this->hasMany(Observacao::class);

    }
    public function documentos()
    {
        return $this->hasMany(Documento::class);

    }
    public function planos_teste()
    {
        return $this->hasMany(PlanoTeste::class);

    }
    public function newQuery(): Builder
    {
        return parent::newQuery()
            ->addSelect('projetos.*')
            ->join('projetos.aplicacoes','aplicacoes.id','=','projetos.aplicacao_id')
            ->join('projetos.aplicacoes_equipes','aplicacoes_equipes.aplicacao_id','=','aplicacoes.id')
            ->join('equipes','equipes.id','=','aplicacoes_equipes.equipe_id')
            ->where('equipes.empresa_id', Auth::user()->empresa_id);
    }
}
