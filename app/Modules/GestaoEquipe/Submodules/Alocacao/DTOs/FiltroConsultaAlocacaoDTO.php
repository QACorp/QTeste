<?php

namespace App\Modules\GestaoEquipe\Submodules\Alocacao\DTOs;

use App\System\Utils\DTO;

class FiltroConsultaAlocacaoDTO extends DTO
{
    public mixed $idUsuario;
    public mixed $idProjeto;
    public mixed $idAplicacao;
    public mixed $dataInicio;
    public mixed $dataTermino;

}
