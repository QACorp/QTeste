<?php

namespace App\Modules\Projetos\Contracts;

use App\Modules\Projetos\DTOs\DocumentoDTO;
use Spatie\LaravelData\DataCollection;

interface DocumentoBusinessContract
{
    public function buscarTodosPorProjeto(int $idProjeto):DataCollection;
    public function salvar(DocumentoDTO $documentoDTO):DocumentoDTO;

    public function excluir(int $idProjeto, int $idDocumento):bool;
}
