<?php

namespace App\Modules\Projetos\Contracts\Repository;

use App\Modules\Projetos\DTOs\DocumentoDTO;
use App\System\Impl\BaseRepositoryContract;
use Spatie\LaravelData\DataCollection;

interface DocumentoRepositoryContract extends BaseRepositoryContract
{
    public function buscarTodosPorProjeto(int $idProjeto):DataCollection;
    public function salvar(DocumentoDTO $documentoDTO):DocumentoDTO;
    public function excluir(int $idDocumento):bool;
}
