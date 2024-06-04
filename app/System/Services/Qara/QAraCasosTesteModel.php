<?php

namespace App\System\Services\Qara;

use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\System\Impl\QAraModelAbstract;
use App\System\Services\Qara\DTOs\QAraMessageDTO;
use OpenAI\Responses\Chat\CreateResponse;
use Spatie\LaravelData\DataCollection;

class QAraCasosTesteModel extends QAraModelAbstract
{

    public static function gerarTexto(QAraMessageDTO $message): DataCollection
    {
        $content =  QAra::getChat(QAraMessageDTO::collection([
            QAraMessageDTO::from([
                'role' => QAraRoleEnum::SYSTEM,
                'content' => 'Você responderá como se fosse um profissional de qualidade de software com conhecimento sobre TDD e elaboração de casos de testes'
            ]),

            QAraMessageDTO::from([
                'role' => QAraRoleEnum::USER,
                'content' => 'Escreva os casos de testes em JSON com o seguinte formato:{casos_teste:[
                    {
                        requisito: "decricao do requisito",
                        titulo: "Título do requisito testado",
                        cenario: "Cenário em que o teste está sendo executado",
                        teste: "Os passos do teste",
                        resultado_esperado: "Resultado esperado ao final do teste"
                        }
                ]}'
            ]),
            QAraMessageDTO::from([
                'role' => QAraRoleEnum::USER,
                'content' => 'Deve retornar uma lista com, no minimo, 10 casos de testes para os requisitos abaixo'
            ]),
            $message
        ]));

        $casosTestes = json_decode($content->choices[0]->message->content);
        return CasoTesteDTO::collection($casosTestes->casos_teste);
    }
}
