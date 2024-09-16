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

class Tarefa extends Model implements Cast
{
    use HasFactory, SoftDeletes;
    protected $table = 'projetos.tarefas';

    protected $fillable = [
      'titulo',
      'tarefa',
      'empresa_id'
    ];

    public function newQuery(): Builder
    {
//        return parent::newQuery()->whereRaw('empresa_id', Auth::user()->empresa_id);
        if (Auth::user()) {
            return parent::newQuery()
                ->where('tarefas.empresa_id', Auth::user()->empresa_id);
        }
        return parent::newQuery();
    }
    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        // TODO: Implement cast() method.
    }
}
