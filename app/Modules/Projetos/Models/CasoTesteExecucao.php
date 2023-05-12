<?php

namespace App\Modules\Projetos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CasoTesteExecucao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'projetos.caso_teste_execucoes';
    protected $fillable = [
        'resultado',
        'user_id',
        'data_execucao',
        'plano_teste_execucao_id',
        'caso_teste_id'
    ];
    public function caso_teste()
    {
        return $this->belongsTo(CasoTeste::class);

    }

    public function plano_teste_execucao()
    {
        return $this->belongsTo(PlanoTesteExecucao::class);

    }
}
