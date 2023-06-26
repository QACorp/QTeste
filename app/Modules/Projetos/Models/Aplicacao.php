<?php

namespace App\Modules\Projetos\Models;

use App\System\DTOs\EquipeDTO;
use App\System\Models\Equipe;
use App\System\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aplicacao extends Model
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
}
