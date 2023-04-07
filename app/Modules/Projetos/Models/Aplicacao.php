<?php

namespace App\Modules\Projetos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aplicacao extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'projetos.aplicacoes';

    protected $fillable = [
      'nome',
      'descricao'
    ];
}
