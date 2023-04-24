<?php

namespace App\Modules\Projetos\Controllers;

use App\Modules\Projetos\Contracts\DocumentoBusinessContract;
use App\Modules\Projetos\DTOs\DocumentoDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentoController
{
    public function __construct(
        private readonly DocumentoBusinessContract $documentoBusiness
    )
    {
    }
    public function salvar(Request $request, int $idAplicacao, int $idProjeto)
    {
        try{
            $documentoDTO = DocumentoDTO::from($request->toArray());
            $documentoDTO->projeto_id = $idProjeto;

            $this->documentoBusiness->salvar($documentoDTO);
            return redirect(route('aplicacoes.projetos.editar',[$idAplicacao, $idProjeto]))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Documento inserido com sucesso!']]);
        }catch (UnprocessableEntityException $exception){
            return redirect(route('aplicacoes.projetos.editar',[$idAplicacao, $idProjeto]))
                ->withErrors($exception->getValidator())
                ->withInput();
        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.projetos.index',$idAplicacao))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Projeto não encontrado']]);
        }
    }

    public function excluir(Request $request, int $idAplicacao, int $idProjeto, int $idDocumento)
    {
        try{
            $this->documentoBusiness->excluir($idProjeto, $idDocumento);
            return redirect(route('aplicacoes.projetos.editar',[$idAplicacao, $idProjeto]))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Documento removido com sucesso!']]);
        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.projetos.index',$idAplicacao))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Projeto não encontrado']]);
        }
    }
}
