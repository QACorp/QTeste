<?php

namespace App\System\Business;

use App\System\Contracts\Business\EmpresaConfiguracaoBusinessContract;
use App\System\Contracts\Repository\EmpresaConfiguracaoRepositoryContract;
use App\System\DTOs\EmpresaConfiguracaoDTO;

use App\System\Impl\BusinessAbstract;
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

    public function buscarPorConfiguracaoPorPrefixo(string $prefixo): DataCollection
    {
        return $this->empresaConfiguracaoRepository->buscarPorConfiguracaoPorPrefixo($prefixo);
    }
}
