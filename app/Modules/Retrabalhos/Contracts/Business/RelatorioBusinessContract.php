<?php

namespace App\Modules\Retrabalhos\Contracts\Business;

use App\Modules\Retrabalhos\DTOs\FiltrosDTO;
use App\Modules\Retrabalhos\DTOs\RetrabalhoDesenvolvedorDTO;
use Spatie\LaravelData\DataCollection;

interface RelatorioBusinessContract
{
    public function relatorioRetrabalhoDesenvolvedor(FiltrosDTO $filtrosDTO, int $idEquipe):DataCollection;
    public function relatorioRetrabalhoTarefa(FiltrosDTO $filtrosDTO, int $idEquipe):DataCollection;
    public function relatorioRetrabalhoAplicacao(FiltrosDTO $filtrosDTO, int $idEquipe):DataCollection;

    public function relatorioMeusRetrabalhos(FiltrosDTO $filtrosDTO, int $idUser):DataCollection;
    public function relatorioMeusCadastros(FiltrosDTO $filtrosDTO, int $idUser):DataCollection;

}
