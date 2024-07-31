<?php

namespace App\System\Models;

use App\System\DTOs\UserDTO;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements Cast, JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected static function boot()
    {
        static::creating(function ($model) {
            $model->empresa_id = auth()->user()->empresa_id;
            $model->password = bcrypt(md5(uniqid('_')));
        });
        parent::boot();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'selected_equipe_id',
        'empresa_id',
        'active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cast(DataProperty $property, mixed $value, array $context): mixed
    {
        return UserDTO::from($value);
    }

    public function equipes(): BelongsToMany
    {
        return $this->belongsToMany(Equipe::class, 'users_equipes');
    }
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function guardName(): array
    {
        return ['web', 'api'];
    }


}
