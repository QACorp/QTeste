<?php

namespace App\Modules\GestaoEquipe\Models;

use App\Modules\GestaoEquipe\Enums\NaturezaEnum;
use App\Modules\Projetos\Models\Projeto;
use App\System\Models\Empresa;
use App\System\Models\Equipe;
use App\System\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alocacao extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'gestao_equipes.alocacoes';
    protected $fillable = [
        'projeto_id',
        'user_id',
        'empresa_id',
        'equipe_id',
        'inicio',
        'termino',
        'concluida',
        'tarefa',
        'natureza',
        'observacao'
    ];

    protected $enums = [
        'natureza' => NaturezaEnum::class
    ];
    protected $casts = [
        'inicio' => 'date',
        'termino' => 'date',
        'concluida' => 'date',
    ];
    public function projeto(): BelongsTo
    {
        return $this->belongsTo(Projeto::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }
    public function equipe(): BelongsTo
    {
        return $this->belongsTo(Equipe::class);
    }
}
