<?php

namespace App\System\Business;

use App\System\Contracts\Business\EmpresaBusinessContract;
use App\System\Contracts\Business\EmpresaConfiguracaoBusinessContract;
use App\System\Contracts\Business\EquipeBusinessContract;
use App\System\Contracts\Repository\EmpresaRepositoryContract;
use App\System\Contracts\Repository\EquipeRepositoryContract;
use App\System\DTOs\EmpresaConfiguracaoDTO;
use App\System\DTOs\EmpresaDTO;
use App\System\DTOs\EquipeDTO;
use App\System\Enums\PermissionEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Impl\BusinessAbstract;
use App\System\Requests\EquipePostRequest;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\DataCollection;

class EmpresaConfiguracaoBusiness extends BusinessAbstract implements EmpresaConfiguracaoBusinessContract
{
    public function __construct(
        private readonly EmpresaConfiguracaoRepositoryContract $empresaConfiguracaoRepository
    )
    {
    }

    public function salvar(EmpresaConfiguracaoDTO $data): EmpresaConfiguracaoDTO
    {
        return $this->empresaConfiguracaoRepository->salvar($data);
    }

    public function alterar(EmpresaConfiguracaoDTO $data): EmpresaConfiguracaoDTO
    {
        return $this->empresaConfiguracaoRepository->alterar($data);
    }

    public function excluir(string $prefixo, string $nome): bool
    {
        return $this->empresaConfiguracaoRepository->excluir($prefixo, $nome);
    }

    public function buscarPorConfiguracao(string $prefixo, string $nome): EmpresaConfiguracaoDTO
    {
        return $this->empresaConfiguracaoRepository->buscarPorConfiguracao($prefixo, $nome);
    }
}
