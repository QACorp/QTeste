<?php

namespace App\System\Business;

use App\System\Contracts\Business\EmpresaBusinessContract;
use App\System\Contracts\Business\EquipeBusinessContract;
use App\System\Contracts\Repository\EmpresaRepositoryContract;
use App\System\Contracts\Repository\EquipeRepositoryContract;
use App\System\DTOs\EmpresaDTO;
use App\System\DTOs\EquipeDTO;
use App\System\Enums\PermissionEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Impl\BusinessAbstract;
use App\System\Requests\EquipePostRequest;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\DataCollection;

class EmpresaBusiness extends BusinessAbstract implements EmpresaBusinessContract
{
    public function __construct(
        private readonly EmpresaRepositoryContract $empresaRepository
    )
    {
    }

    public function salvar(EmpresaDTO $data): EmpresaDTO
    {
        return $this->empresaRepository->salvar($data);
    }

    public function buscarEmpresaPorIdUsuario(int $idUsuario): EmpresaDTO
    {
        return $this->empresaRepository->buscarEmpresaPorIdUsuario($idUsuario);
    }

    public function buscarAdministradorPorIdEmpresa(int $idEmpresa): DataCollection
    {
        return $this->empresaRepository->buscarAdministradorPorIdEmpresa($idEmpresa);
    }

    public function alterar(EmpresaDTO $data): EmpresaDTO
    {
        $this->can(PermissionEnum::ALTERAR_EMPRESA->name);
        return $this->empresaRepository->alterar($data);
    }
}
