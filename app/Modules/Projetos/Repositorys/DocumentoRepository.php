<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\Repository\DocumentoRepositoryContract;
use App\Modules\Projetos\DTOs\DocumentoDTO;
use App\Modules\Projetos\Models\Documento;
use App\Modules\Projetos\Models\Projeto;
use App\System\Impl\BaseRepository;
use Spatie\LaravelData\DataCollection;

class DocumentoRepository extends BaseRepository  implements DocumentoRepositoryContract
{

    public function buscarTodosPorProjeto(int $idProjeto): DataCollection
    {
        return DocumentoDTO::collection(
            Documento::where('projeto_id', $idProjeto)
                ->orderBy('created_at', 'DESC')
                ->get()
        );
    }

    public function salvar(DocumentoDTO $documentoDTO): DocumentoDTO
    {
        $documento = new Documento($documentoDTO->toArray());
        $documento->save();
        return DocumentoDTO::from($documento);
    }

    public function excluir(int $idDocumento): bool
    {
        return Documento::find($idDocumento)->delete();
    }
}
