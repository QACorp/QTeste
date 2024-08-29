<?php

namespace App\Modules\GestaoEquipe\Checkpoint\Models;

use App\Modules\Projetos\Models\Projeto;
use App\System\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'tarefa',
        'compareceu'
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

}
