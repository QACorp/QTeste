<?php

namespace App\Modules\GestaoEquipe\Checkpoint\Models;

use App\Modules\Projetos\Models\Projeto as BaseProjeto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projeto extends BaseProjeto
{
    use HasFactory, SoftDeletes;
    public function checkpoints(): BelongsTo
    {
        return $this->belongsTo(Checkpoint::class);
    }


}