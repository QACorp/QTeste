<?php

namespace App\System\Impl;

use App\System\Services\Qara\DTOs\QAraMessageDTO;
use App\System\Utils\DTO;
use Illuminate\Support\Collection;
use OpenAI\Responses\Chat\CreateResponse;
use Spatie\LaravelData\DataCollection;

abstract class QAraModelAbstract
{
    abstract public static  function gerarTexto(QAraMessageDTO $message):DataCollection ;
}
