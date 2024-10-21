<?php

namespace App\Modules\GestaoEquipe\Submodules\Alocacao\Models;

use App\Modules\GestaoEquipe\Submodules\Alocacao\Enums\NaturezaEnum;
use App\Modules\Projetos\Models\Projeto;
use App\Modules\Projetos\Models\Tarefa;
use App\System\Models\Empresa;
use App\System\Models\Equipe;
use App\System\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        'tarefa_id',
        'natureza',
        'observacao',
        'prorrogacao',
        'motivo_prorrogacao'
    ];

    protected $enums = [
        'natureza' => NaturezaEnum::class
    ];
    protected $casts = [
        'inicio' => 'date',
        'termino' => 'date',
        'concluida' => 'date',
        'prorrogacao' => 'date'
    ];
    public function projeto(): BelongsTo
    {
        return $this->belongsTo(Projeto::class);
    }
    public function tarefa(): BelongsTo
    {
        return $this->belongsTo(Tarefa::class);
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
    public function cancelamento(): HasOne
    {
        return $this->hasOne(AlocacaoCancelamento::class);
    }
    public function newQuery(): Builder
    {
        if(Auth::user()) {
            return parent::newQuery()
                ->where('alocacoes.empresa_id', Auth::user()->empresa_id);
        }
        return parent::newQuery();
    }
}
