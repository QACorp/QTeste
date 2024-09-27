<?php

namespace App\Modules\GestaoEquipe\Observacao\Models;

use App\Modules\GestaoEquipe\Alocacao\Models\Alocacao;
use App\Modules\Projetos\Models\Projeto;
use App\Modules\Projetos\Models\Tarefa;
use App\System\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Observacao extends Model
{
    use HasFactory, SoftDeletes;
    //Criar model com base na tabela criada na migration 2024_08_27_020941_add_table_checkpoint.php
    protected $table = 'gestao_equipes.observacoes';
    protected $fillable = [
        'user_id',
        'criador_user_id',
        'data',
        'observacao',
        'user',
        'criador'
    ];
    protected $dates = [

    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function criador():BelongsTo
    {
        return $this->belongsTo(User::class, 'criador_user_id');
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
