<?php

namespace App\System\Traits;

use Illuminate\Support\Facades\App;

trait Configuracao
{

    public function buscarConfiguracao(string $prefixo, string $nome)
    {
        $configuracaoBusiness = App::make(EmpresaConfiguracaoBusinessContract::class);
        return $configuracaoBusiness->buscarPorConfiguracao($prefixo, $nome);
    }

    public function salvarConfiguracao(string $prefixo, string $nome, string $valor, string $descricao = null)
    {
        $configuracao = $this->buscarConfiguracao($prefixo, $nome);
        if ($configuracao) {
            $configuracao->update([
                'valor' => $valor,
                'descricao' => $descricao
            ]);
        } else {
            $this->configuracoes()->create([
                'nome' => $nome,
                'valor' => $valor,
                'descricao' => $descricao,
                'prefixo_modulo' => $prefixo
            ]);
        }
    }

    public function excluirConfiguracao(string $prefixo, string $nome)
    {
        $configuracao = $this->buscarConfiguracao($prefixo, $nome);
        if ($configuracao) {
            $configuracao->delete();
        }
    }
}
