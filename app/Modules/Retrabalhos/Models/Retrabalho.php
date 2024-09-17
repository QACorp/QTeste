<?php

namespace App\Modules\Retrabalhos\Models;


use App\Modules\Projetos\Models\Aplicacao;
use App\Modules\Projetos\Models\CasoTeste;
use App\Modules\Projetos\Models\Tarefa;
use App\Modules\Retrabalhos\Enums\TipoRetrabalhoEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Retrabalho extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'projetos.retrabalhos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'descricao',
        'data',
        'tarefa_id',
        'motivo_exclusao',
        'tipo_retrabalho_id',
        'usuario_criador_id',
        'usuario_id',
        'projeto_id',
        'aplicacao_id',
        'caso_teste_id',
        'criticidade'
    ];
    protected $visible = [
        'id',
        'descricao',
        'data',
        'motivo_exclusao',
        'tipo_retrabalho_id',
        'usuario_criador_id',
        'usuario_id',
        'tarefa_id',
        'projeto_id',
        'aplicacao_id',
        'caso_teste_id',
        'usuario',
        'projeto',
        'aplicacao',
        'caso_teste',
        'usuario_criador',
        'criticidade',
        'tarefa'
    ];
    protected $casts = [
        'data' => 'date'
    ];
    public function tipo_retrabalho()
    {
        return $this->belongsTo(TipoRetrabalho::class, 'tipo_retrabalho_id');
    }
    public function usuario_criador()
    {
        return $this->belongsTo(User::class, 'usuario_criador_id');
    }
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
    public function tarefa()
    {
        return $this->belongsTo(Tarefa::class, 'tarefa_id');
    }
    public function projeto()
    {
        return $this->belongsTo(Projeto::class, 'projeto_id');
    }
    public function aplicacao()
    {
        return $this->belongsTo(Aplicacao::class, 'aplicacao_id');
    }
    public function caso_teste()
    {
        return $this->belongsTo(CasoTeste::class, 'caso_teste_id');
    }

    public function newQuery(): Builder
    {
        if(Auth::user()){
            return parent::newQuery()
                ->join('projetos.aplicacoes','aplicacoes.id','=','retrabalhos.aplicacao_id')
                ->join('projetos.aplicacoes_equipes','aplicacoes_equipes.aplicacao_id','=','aplicacoes.id')
                ->join('equipes','equipes.id','=','aplicacoes_equipes.equipe_id')
                ->where('equipes.empresa_id', Auth::user()->empresa_id);
        }
        return parent::newQuery();
    }
}
