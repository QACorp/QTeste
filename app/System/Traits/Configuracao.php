<?php

namespace App\System\Traits;

use App\System\Contracts\Business\EmpresaConfiguracaoBusinessContract;
use App\System\DTOs\EmpresaConfiguracaoDTO;
use App\System\Exceptions\NotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

trait Configuracao
{
    private ?EmpresaConfiguracaoBusinessContract $configuracaoBusiness = null;
    public function getConfiguracaoBusiness():EmpresaConfiguracaoBusinessContract
    {
        if(!$this->configuracaoBusiness){
            $this->configuracaoBusiness = App::make(EmpresaConfiguracaoBusinessContract::class);
        }
        return $this->configuracaoBusiness;
    }

    public function buscarConfiguracao(string $prefixo, string $nome)
    {
        $configuracaoBusiness = $this->getConfiguracaoBusiness();
        $configuracao =  $configuracaoBusiness->buscarPorConfiguracao($prefixo, $nome);
        if($configuracao->valor_criptografado){
            $configuracao->valor = Crypt::decryptString($configuracao->valor);
        }
        return $configuracao;
    }

    public function salvarConfiguracao(string $prefixo, string $nome, string $valor, string $descricao = null, $criptografado = false)
    {
        $configuracaoBusiness = $this->getConfiguracaoBusiness();
        if($criptografado){
            $valor = Crypt::encryptString($valor);
        }
        try{
            $configuracao = $configuracaoBusiness->buscarPorConfiguracao($prefixo, $nome);
            return $configuracaoBusiness->alterar(EmpresaConfiguracaoDTO::from([
                'id' => $configuracao->id,
                'nome' => $configuracao->nome,
                'valor' => $valor,
                'descricao' => $descricao,
                'prefixo_modulo' => $configuracao->prefixo_modulo,
                'empresa_id' => $configuracao->empresa_id,
                'valor_criptografado' => $criptografado
            ]));
        }catch (NotFoundException $e){
            return $configuracaoBusiness->salvar(EmpresaConfiguracaoDTO::from([
                'nome' => $nome,
                'valor' => $valor,
                'descricao' => $descricao,
                'prefixo_modulo' => $prefixo,
                'valor_criptografado' => $criptografado,
                'empresa_id' => Auth::user()->empresa_id
            ]));
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
