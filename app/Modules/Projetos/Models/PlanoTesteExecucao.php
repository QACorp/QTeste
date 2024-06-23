<?php

namespace App\Modules\Projetos\Models;

use App\System\Models\Equipe;
use App\System\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class PlanoTesteExecucao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'projetos.plano_teste_execucoes';
    protected $casts = [
        'created_at' => 'datetime',
    ];
    protected $fillable = [
        'resultado',
        'user_id',
        'data_execucao',
        'plano_teste_id',
        'caso_teste_id',
        'equipe_id'
    ];
    public function caso_teste_execucao()
    {
        return $this->hasMany(CasoTesteExecucao::class);

    }
    public function user()
    {
        return $this->belongsTo(User::class);

    }
    public function plano_teste()
    {
        return $this->belongsTo(PlanoTeste::class);

    }
    public function equipe(): BelongsTo
    {
        return $this->belongsTo(Equipe::class);
    }

    public function newQuery(): Builder
    {
        return parent::newQuery()
            ->addSelect('plano_teste_execucoes.*')
            ->join('equipes','equipes.id','=','plano_teste_execucoes.equipe_id')
            ->where('equipes.empresa_id', Auth::user()->empresa_id);
    }
}
