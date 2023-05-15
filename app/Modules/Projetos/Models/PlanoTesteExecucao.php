<?php

namespace App\Modules\Projetos\Models;

use App\System\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanoTesteExecucao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'projetos.plano_teste_execucoes';
    protected $casts = [
        'created_at' => 'datetime',
    ];
    protected $fillable = [
        'resultado',
        'user_id',
        'data_execucao',
        'plano_teste_id',
        'caso_teste_id'
    ];
    public function caso_teste_execucao()
    {
        return $this->hasMany(CasoTesteExecucao::class);

    }
    public function user()
    {
        return $this->belongsTo(User::class);

    }
    public function plano_teste()
    {
        return $this->belongsTo(PlanoTeste::class);

    }
}
