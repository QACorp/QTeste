<?php

namespace App\Modules\Projetos\Models;

use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\System\Models\Equipe;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class CasoTeste extends Model implements Cast
{
    use HasFactory, SoftDeletes;

    protected $table = 'projetos.casos_teste';
    protected $fillable = [
        'titulo',
        'requisito',
        'cenario',
        'teste',
        'resultado_esperado',
        'status'
    ];

    public function planos_teste(): BelongsToMany
    {
        return $this->belongsToMany(PlanoTeste::class,'projetos.caso_teste_plano_teste')->using(CasoTestePlanoTeste::class);
    }
    public function execucao()
    {
        return $this->hasMany(CasoTesteExecucao::class);

    }

    public function equipes(): BelongsToMany
    {
        return $this->belongsToMany(Equipe::class, 'projetos.casos_teste_equipes');
    }

    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        return CasoTesteDTO::from($value);
    }
}
