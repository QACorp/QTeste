<?php

namespace App\Modules\GestaoEquipe\Submodules\Checkpoint\Models;

use App\Modules\GestaoEquipe\Submodules\Alocacao\Models\Alocacao;
use App\Modules\Projetos\Models\Projeto;
use App\Modules\Projetos\Models\Tarefa;
use App\System\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Checkpoint extends Model
{
    use HasFactory, SoftDeletes;
    //Criar model com base na tabela criada na migration 2024_08_27_020941_add_table_checkpoint.php
    protected $table = 'gestao_equipes.checkpoints';
    protected $fillable = [
        'projeto_id',
        'criador_user_id',
        'user_id',
        'descricao',
        'data',
        'tarefa_id',
        'compareceu',
        'equipe_id',
        'alocacao_id'
    ];
    protected $dates = [
        'data',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $casts = [
        'compareceu' => 'boolean'
    ];
    public function tarefa(): BelongsTo
    {
        return $this->belongsTo(Tarefa::class, 'tarefa_id');
    }
    public function projeto(): BelongsTo
    {
        return $this->belongsTo(Projeto::class, 'projeto_id');
    }
    public function criador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'criador_user_id');
    }
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function alocacao():BelongsTo
    {
        return $this->belongsTo(Alocacao::class, 'alocacao_id');
    }

    public function newQuery(): Builder
    {
        if(Auth::user()){
            return parent::newQuery()
                ->join('users as criador', 'criador.id', '=', 'checkpoints.criador_user_id')
                ->where('criador.empresa_id', Auth::user()->empresa_id);

        }
        return parent::newQuery();
    }

}
