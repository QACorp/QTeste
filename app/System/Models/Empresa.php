<?php

namespace App\System\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'empresas';

    protected $fillable = [
        'nome',
        'usuarios'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function equipes(): HasMany
    {
        return $this->hasMany(Equipe::class);
    }
    public function configuracoes(): HasMany
    {
        return $this->hasMany(EmpresaConfiguracao::class);
    }
}
