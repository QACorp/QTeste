<?php

namespace App\Modules\Projetos\Models;

use App\System\Models\Equipe;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class CasoTesteExecucao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'projetos.caso_teste_execucoes';
    protected $fillable = [
        'resultado',
        'user_id',
        'data_execucao',
        'plano_teste_execucao_id',
        'caso_teste_id',
        'equipe_id'
    ];
    public function caso_teste()
    {
        return $this->belongsTo(CasoTeste::class);

    }

    public function equipe(): BelongsTo
    {
        return $this->belongsTo(Equipe::class);
    }
    public function plano_teste_execucao()
    {
        return $this->belongsTo(PlanoTesteExecucao::class);

    }
    public function newQuery(): Builder
    {
        return parent::newQuery()
            ->addSelect('caso_teste_execucoes.*')
             ->join('equipes','equipes.id','=','caso_teste_execucoes.equipe_id')
            ->where('equipes.empresa_id', Auth::user()->empresa_id);
    }
}
