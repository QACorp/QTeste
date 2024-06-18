<?php

namespace App\System\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmpresaConfiguracao extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'empresa_configuracoes';

    protected $fillable = [
        'nome',
        'valor',
        'valor_criptografado',
        'descricao',
        'prefixo_modulo',
        'empresa_id'
    ];
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }
}
