<?php

namespace App\System\Traits;

use App\System\Contracts\Business\EmpresaConfiguracaoBusinessContract;
use App\System\DTOs\EmpresaConfiguracaoDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Services\Mail\DTOs\MailDTO;
use App\System\Services\Mail\QTesteMail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Spatie\LaravelData\DataCollection;

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

    public function buscarConfiguracao(string $prefixo, string $nome):EmpresaConfiguracaoDTO
    {
        $configuracaoBusiness = $this->getConfiguracaoBusiness();
        $configuracao =  $configuracaoBusiness->buscarPorConfiguracao($prefixo, $nome);
        if($configuracao->valor_criptografado){
            $configuracao->valor = Crypt::decryptString($configuracao->valor);
        }
        return $configuracao;
    }

    public function buscarConfiguracoesPorPrefixo(string $prefixo): DataCollection
    {
        $configuracaoBusiness = $this->getConfiguracaoBusiness();
        $configuracoes =  $configuracaoBusiness->buscarPorConfiguracaoPorPrefixo($prefixo);
        $configuracoes->each(function($item){
            if($item->valor_criptografado){
                $item->valor = Crypt::decryptString($item->valor);
            }
        });
        return $configuracoes;
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

    public function configureMail():void
    {
        $configuracao = $this->buscarConfiguracoesPorPrefixo('core');

        QTesteMail::configure(MailDTO::from([
            'mailMailer' => $configuracao->where('nome','MAIL_MAILER')->first()?->valor,
            'mailHost' => $configuracao->where('nome','MAIL_HOST')->first()?->valor,
            'mailPort' => $configuracao->where('nome','MAIL_PORT')->first()?->valor,
            'mailUsername' => $configuracao->where('nome','MAIL_USERNAME')->first()?->valor,
            'mailPassword' => $configuracao->where('nome','MAIL_PASSWORD')->first()?->valor,
            'mailEncryption' => $configuracao->where('nome','MAIL_ENCRYPTION')->first()?->valor,
            'mailFromAddress' => $configuracao->where('nome','MAIL_FROM_ADDRESS')->first()?->valor,
            'mailFromName' => $configuracao->where('nome','MAIL_FROM_NAME')->first()?->valor
        ]));
    }
}
