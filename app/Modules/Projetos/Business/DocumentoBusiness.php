<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\DocumentoBusinessContract;
use App\Modules\Projetos\Contracts\DocumentoRepositoryContract;
use App\Modules\Projetos\Contracts\ProjetoBusinessContract;
use App\Modules\Projetos\DTOs\DocumentoDTO;
use App\Modules\Projetos\Requests\DocumentosPostRequest;
use App\Modules\Projetos\Requests\ProjetosPostRequest;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\DataCollection;

class DocumentoBusiness implements DocumentoBusinessContract
{
    public function __construct(
        private readonly DocumentoRepositoryContract $documentoRepository,
        private readonly ProjetoBusinessContract $projetoBusiness
    )
    {
    }

    public function buscarTodosPorProjeto(int $idProjeto): DataCollection
    {
        $projeto = $this->projetoBusiness->buscarPorIdProjeto($idProjeto);
        if($projeto == null)
            throw new NotFoundException();

        return $this->documentoRepository->buscarTodosPorProjeto($idProjeto);
    }

    public function salvar(DocumentoDTO $documentoDTO): DocumentoDTO
    {
        $projeto = $this->projetoBusiness->buscarPorIdProjeto($documentoDTO->projeto_id);
        if($projeto == null)
            throw new NotFoundException();

        $validator = Validator::make($documentoDTO->toArray(), (new DocumentosPostRequest())->rules());

        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }
        return $this->documentoRepository->salvar($documentoDTO);

    }

    public function excluir(int $idProjeto, int $idDocumento): bool
    {
        $projeto = $this->projetoBusiness->buscarPorIdProjeto($idProjeto);
        if($projeto == null)
            throw new NotFoundException();

        return $this->documentoRepository->excluir($idDocumento);

    }
}
