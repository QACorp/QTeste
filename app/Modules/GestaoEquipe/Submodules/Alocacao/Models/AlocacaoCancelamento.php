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
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class AlocacaoCancelamento extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'gestao_equipes.alocacao_cancelamentos';
    protected $fillable = [
        'alocacao_id',
        'user_id',
        'motivo',
    ];

    protected $enums = [
        'natureza' => NaturezaEnum::class
    ];
    protected $casts = [

    ];
    public function alocacao(): BelongsTo
    {
        return $this->belongsTo(Alocacao::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function newQuery(): Builder
    {
        if(Auth::user()) {
            return parent::newQuery()
                ->addSelect('alocacao_cancelamentos.*')
                ->join('gestao_equipes.alocacoes', 'alocacoes.id', '=', 'alocacao_cancelamentos.alocacao_id')
                ->where('alocacoes.empresa_id', Auth::user()->empresa_id);
        }
        return parent::newQuery();
    }
}
