<?php

namespace App\Modules\Projetos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projeto extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'projetos.projetos';
    protected $casts = [
        'inicio' => 'date',
        'termino' => 'date'
    ];
    protected $fillable = [
        'nome',
        'descricao',
        'inicio',
        'termino',
        'aplicacao_id'
    ];
    public function aplicacao()
    {
        return $this->belongsTo(Aplicacao::class);

    }
}
