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
        'tipo_retrabalho_id',
        'usuario_criador_id',
        'usuario_id',
        'projeto_id',
        'aplicacao_id',
        'caso_teste_id',
        'criticidade'
    ];
    protected $visible = [
        'id',
        'descricao',
        'data',
        'motivo_exclusao',
        'numero_tarefa',
        'tipo_retrabalho_id',
        'usuario_criador_id',
        'usuario_id',
        'projeto_id',
        'aplicacao_id',
        'caso_teste_id',
        'usuario',
        'projeto',
        'aplicacao',
        'caso_teste',
        'usuario_criador',
        'criticidade'
    ];
    // Criar chaves estrangeiras
    public function tipo_retrabalho()
    {
        return $this->belongsTo(TipoRetrabalho::class, 'tipo_retrabalho_id');
    }
    public function usuario_criador()
    {
        return $this->belongsTo(User::class, 'usuario_criador_id');
    }
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
    public function projeto()
    {
        return $this->belongsTo(Projeto::class, 'projeto_id');
    }
    public function aplicacao()
    {
        return $this->belongsTo(Aplicacao::class, 'aplicacao_id');
    }
    public function caso_teste()
    {
        return $this->belongsTo(CasoTeste::class, 'caso_teste_id');
    }
}
