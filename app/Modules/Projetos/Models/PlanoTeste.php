<?php

namespace App\Modules\Projetos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanoTeste extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'projetos.planos_teste';
    protected $casts = [
        'created_at' => 'datetime',
    ];
    protected $fillable = [
        'titulo',
        'descricao',
        'user_id',
        'projeto_id'
    ];

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);

    }

    public function casos_teste(): BelongsToMany
    {
        return $this->belongsToMany(CasoTeste::class)->using(CasoTestePlanoTeste::class);
    }
}
