<?php

namespace App\Modules\Projetos\Models;

use App\System\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Observacao extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'projetos.observacoes';
    protected $casts = [
        'created_at' => 'datetime',
    ];
    protected $fillable = [
        'descricao',
        'projeto_id'
    ];

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);

    }
    public function user()
    {
        return $this->belongsTo(User::class);

    }
}
