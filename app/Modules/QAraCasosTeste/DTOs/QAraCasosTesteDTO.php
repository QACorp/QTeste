<?php

namespace App\Modules\QAraCasosTeste\DTOs;

use Spatie\LaravelData\Attributes\Validation\Required;

class QAraCasosTesteDTO
{
    #[Required]
    public int $idProjeto;
    #[Required]
    public int $idAplicacao;
    #[Required]
    public string $requisitos;
}
