<?php

namespace App\Modules\QAraCasosTeste\Business;

use App\Modules\Projetos\Contracts\Business\AplicacaoBusinessContract;
use App\Modules\Projetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\QAraCasosTeste\Contracts\Business\QAraCasosTesteBusinessContract;
use App\Modules\QAraCasosTeste\DTOs\QAraCasosTesteDTO;
use App\Modules\QAraCasosTeste\Services\QAra\QAraCasosTesteModel;
use App\System\Services\Qara\DTOs\QAraMessageDTO;
use App\System\Services\Qara\QAraRoleEnum;

use Spatie\LaravelData\DataCollection;

class QAraCasosTesteBusiness implements QAraCasosTesteBusinessContract
{
    public function __construct(
        private readonly AplicacaoBusinessContract $aplicacaoBusiness,
        private readonly ProjetoBusinessContract $projetoBusiness,
    )
    {
    }

    public function gerarTextoIA(QAraCasosTesteDTO $qaraCasosTesteDTO, int $idEquipe): DataCollection
    {

        $aplicacao = $this->aplicacaoBusiness->buscarPorId($qaraCasosTesteDTO->idAplicacao,$idEquipe);

        $projeto = $this->projetoBusiness->buscarPorIdProjeto($qaraCasosTesteDTO->idProjeto, $idEquipe);


        $casosTeste = QAraCasosTesteModel::gerarTexto(
            QAraMessageDTO::collection([
                QAraMessageDTO::from([
                    'role' => QAraRoleEnum::USER->value,
                    'content' => 'Aqui está uma descrição da aplicação: '.$aplicacao->descricao
                ]),
                QAraMessageDTO::from([
                    'role' => QAraRoleEnum::USER->value,
                    'content' => 'Aqui está uma descrição do projeto que será desenvolvido: '.$projeto->descricao
                ]),
                QAraMessageDTO::from([
                    'role' => QAraRoleEnum::USER->value,
                    'content' => $qaraCasosTesteDTO->requisitos
                ]),
            ])
        );
        return $casosTeste;
    }
}
