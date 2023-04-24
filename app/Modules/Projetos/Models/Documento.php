<?php

namespace App\Modules\Projetos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documento extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'projetos.documentos';
    protected $casts = [
        'created_at' => 'datetime',
    ];
    protected $fillable = [
        'titulo',
        'descricao',
        'url',
        'projeto_id'
    ];
    public function projeto()
    {
        return $this->belongsTo(Projeto::class);

    }
}
