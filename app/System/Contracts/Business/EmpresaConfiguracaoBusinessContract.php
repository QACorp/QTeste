<?php

namespace App\System\Contracts\Business;

use App\System\DTOs\EmpresaConfiguracaoDTO;
use Spatie\LaravelData\DataCollection;

interface EmpresaConfiguracaoBusinessContract
{
    public function salvar(EmpresaConfiguracaoDTO $data): EmpresaConfiguracaoDTO;
    public function alterar(EmpresaConfiguracaoDTO $data): EmpresaConfiguracaoDTO;
    public function excluir(string $prefixo, string $nome): bool;
    public function buscarPorConfiguracao(string $prefixo, string $nome): EmpresaConfiguracaoDTO;
    public function buscarPorConfiguracaoPorPrefixo(string $prefixo): DataCollection;
}
