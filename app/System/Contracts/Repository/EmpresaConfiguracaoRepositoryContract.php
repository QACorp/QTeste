<?php

namespace App\System\Contracts\Repository;

use App\System\DTOs\EmpresaConfiguracaoDTO;
use App\System\DTOs\EmpresaDTO;
use Spatie\LaravelData\DataCollection;

interface EmpresaConfiguracaoRepositoryContract
{
    public function salvar(EmpresaConfiguracaoDTO $data): EmpresaConfiguracaoDTO;
    public function alterar(EmpresaConfiguracaoDTO $data): EmpresaConfiguracaoDTO;
    public function excluir(string $prefixo, string $nome): bool;
    public function buscarPorConfiguracao(string $prefixo, string $nome): EmpresaConfiguracaoDTO;
    public function buscarPorConfiguracaoPorPrefixo(string $prefixo): DataCollection;

}
