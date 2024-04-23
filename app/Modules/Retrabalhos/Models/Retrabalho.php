<?php

namespace App\Modules\Retrabalhos\Models;


use App\Modules\Projetos\Models\Aplicacao;
use App\Modules\Projetos\Models\CasoTeste;
use App\Modules\Retrabalhos\Enums\TipoRetrabalhoEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Retrabalho extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'projetos.retrabalhos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'descricao',
        'data',
        'motivo_exclusao',
        'numero_tarefa',
        'id_tipo_retrabalho',
        'id_usuario_criador',
        'id_usuario',
        'id_projeto',
        'id_aplicacao',
        'id_caso_teste'
    ];
    // Criar chaves estrangeiras
    public function tipo_retrabalho()
    {
        return $this->belongsTo(TipoRetrabalho::class, 'id_tipo_retrabalho');
    }
    public function usuario_criador()
    {
        return $this->belongsTo(User::class, 'id_usuario_criador');
    }
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
    public function projeto()
    {
        return $this->belongsTo(Projeto::class, 'id_projeto');
    }
    public function aplicacao()
    {
        return $this->belongsTo(Aplicacao::class, 'id_aplicacao');
    }
    public function caso_teste()
    {
        return $this->belongsTo(CasoTeste::class, 'id_caso_teste');
    }
}
