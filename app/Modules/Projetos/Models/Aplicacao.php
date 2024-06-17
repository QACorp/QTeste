<?php

namespace App\Modules\Projetos\Models;

use App\Modules\Projetos\DTOs\AplicacaoDTO;
use App\System\DTOs\EquipeDTO;
use App\System\Models\Equipe;
use App\System\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class Aplicacao extends Model implements Cast
{
    use HasFactory, SoftDeletes;
    protected $table = 'projetos.aplicacoes';

    protected $fillable = [
      'nome',
      'descricao'
    ];

    public function equipes(): BelongsToMany
    {
        return $this->belongsToMany(Equipe::class, 'projetos.aplicacoes_equipes');
    }

    public function projetos()
    {
        return $this->hasMany(Projeto::class);

    }

    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        return AplicacaoDTO::from($value);
    }
    public function newQuery(): Builder
    {
//        return parent::newQuery()->whereRaw('empresa_id', Auth::user()->empresa_id);
        return parent::newQuery()
            ->addSelect('aplicacoes.*')
            ->join('projetos.aplicacoes_equipes','aplicacoes_equipes.aplicacao_id','=','aplicacoes.id')
            ->join('equipes','equipes.id','=','aplicacoes_equipes.equipe_id')
            ->where('equipes.empresa_id', Auth::user()->empresa_id);
    }
}
