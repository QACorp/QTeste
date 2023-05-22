<?php

namespace App\Modules\Projetos\Controllers;

use App\Modules\Projetos\Contracts\ObservacaoBusinessContract;
use App\Modules\Projetos\DTOs\ObservacaoDTO;
use App\System\Enuns\PermisissionEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ObservacaoController extends Controller
{
    public function __construct(
        private readonly ObservacaoBusinessContract $observacaoBusiness
    )
    {
    }

    public function salvar(Request $request, int $idAplicacao, int $idProjeto)
    {
        Auth::user()->can(PermisissionEnum::ADICIONAR_COMENTARIO_PROJETO->value);
        try{
            $observacaoDTO = ObservacaoDTO::from($request->all());
            $observacaoDTO->projeto_id = $idProjeto;

            $this->observacaoBusiness->salvar($observacaoDTO);

            return redirect(route('aplicacoes.projetos.editar',[$idAplicacao, $idProjeto]))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Observação inserida com sucesso!']]);
        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.projetos.index',$idAplicacao))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Projeto não encontrado']]);
        }catch (UnprocessableEntityException $exception) {
            return redirect(route('aplicacoes.projetos.editar', [$idAplicacao, $idProjeto]))
                ->withErrors($exception->getValidator())
                ->withInput();
        }


    }
}
