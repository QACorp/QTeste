<?php

namespace App\System\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipe  extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'equipes';

    protected $fillable = [
        'id',
        'nome'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_equipes');
    }
}
