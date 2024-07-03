<?php

namespace App\System\Business;

use App\System\Contracts\Business\CoreConfiguracaoBusinessContract;
use App\System\Requests\ConfiguracaoRequest;
use App\System\Traits\Configuracao;
use App\System\Traits\TransactionDatabase;

class CoreConfiguracaoBusiness implements CoreConfiguracaoBusinessContract
{
    use Configuracao, TransactionDatabase;


    public function salvarConfiguracaoCore(ConfiguracaoRequest $configuracaoRequest): bool
    {
        try {
            $this->startTransaction();
            $this->alterarConfiguracoesEmail($configuracaoRequest);

            $this->commit();
            return true;
        }catch (UnprocessableEntityException $exception){
            $this->rollback();
            throw  $exception;
        }
    }
    public function alterarConfiguracoesEmail(ConfiguracaoRequest $configuracaoRequest):bool
    {
        $this->salvarConfiguracao('core', 'MAIL_MAILER', $configuracaoRequest->get('MAIL_MAILER'));
        $this->salvarConfiguracao('core', 'MAIL_HOST', $configuracaoRequest->get('MAIL_HOST'));
        $this->salvarConfiguracao('core', 'MAIL_PORT', $configuracaoRequest->get('MAIL_PORT'));
        $this->salvarConfiguracao('core', 'MAIL_USERNAME', $configuracaoRequest->get('MAIL_USERNAME'));
        $this->salvarConfiguracao('core', 'MAIL_PASSWORD', $configuracaoRequest->get('MAIL_PASSWORD'));
        $this->salvarConfiguracao('core', 'MAIL_ENCRYPTION', $configuracaoRequest->get('MAIL_ENCRYPTION'));
        $this->salvarConfiguracao('core', 'MAIL_FROM_ADDRESS', $configuracaoRequest->get('MAIL_FROM_ADDRESS'));
        $this->salvarConfiguracao('core', 'MAIL_FROM_NAME', $configuracaoRequest->get('MAIL_FROM_NAME'));
        $this->salvarConfiguracao('core', 'SEND_MAIL_REWORK', $configuracaoRequest->get('SEND_MAIL_REWORK'));
        return true;
    }
}
