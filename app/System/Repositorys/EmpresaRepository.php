<?php

namespace App\System\Repositorys;

use App\System\Contracts\Business\UserBusinessContract;
use App\System\Contracts\Repository\EmpresaRepositoryContract;
use App\System\DTOs\EmpresaDTO;
use App\System\DTOs\UserDTO;
use App\System\Enums\PermissionEnum;
use App\System\Enums\RoleEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Impl\BaseRepository;
use App\System\Models\Empresa;
use App\System\Models\User;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\DataCollection;

class EmpresaRepository extends BaseRepository  implements EmpresaRepositoryContract
{
    public function __construct(
        private readonly UserBusinessContract $userBusiness
    )
    {
    }

    public function salvar(EmpresaDTO $data): EmpresaDTO
    {
        $empresa = new Empresa($data->toArray());
        $empresa->save();
        return EmpresaDTO::from($empresa);
    }

    public function buscarEmpresaPorIdUsuario(int $idUsuario): EmpresaDTO
    {
        $usuario = $this->userBusiness->buscarPorId($idUsuario);
        $empresa = Empresa::find($usuario->empresa_id);
        if (!$empresa) {
            throw new NotFoundException('Empresa não encontrada');
        }
        return EmpresaDTO::from($empresa);
    }

    public function buscarAdministradorPorIdEmpresa(int $idEmpresa): DataCollection
    {
        //Criar consulta que retorno os usuários pertecente a empresa $idEmpresa e que possuem a permissão de administrador
        $usuarios = User::role(RoleEnum::ADMINISTRADOR->value)
                        ->where('empresa_id', $idEmpresa)
                        ->get();
        return UserDTO::collection($usuarios);

    }

    public function alterar(EmpresaDTO $data): EmpresaDTO
    {
        $empresa = Empresa::find($data->id);
        if (!$empresa) {
            throw new NotFoundException('Empresa não encontrada');
        }
        $empresa->fill($data->except('id')->toArray());
        $empresa->save();
        return EmpresaDTO::from($empresa);
    }
}
