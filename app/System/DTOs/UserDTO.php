<?php

namespace App\System\DTOs;

use App\Modules\Projetos\Casts\CastCasosTesteCollection;
use App\System\Casts\CastEquipes;
use App\System\Casts\CastRoles;
use App\System\Utils\DTO;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Contracts\DataCollectable;

class UserDTO extends DTO
{
    public ?int $id = null;
    public ?string $name;
    public ?string $email;
    public ?string $password = null;
    public ?string $password_confirmation;
    #[WithCast(CastRoles::class)]
    public ?DataCollectable $roles;
    #[WithCast(CastEquipes::class)]
    public ?DataCollectable $equipes;
    public ?int $empresa_id;
    public ?EmpresaDTO $empresa;
    public bool $active = true;


    public function __construct()
    {
        if($this->password == null && $this->id == null){
            $this->password = Hash::make(md5(uniqid('_')));
        }

    }

}
