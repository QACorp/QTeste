<?php

namespace App\System\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\System\DTOs\UserDTO;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\Permission\Traits\HasRoles;
use Yajra\Acl\Traits\HasRoleAndPermission;

class User extends Authenticatable implements Cast
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

}
