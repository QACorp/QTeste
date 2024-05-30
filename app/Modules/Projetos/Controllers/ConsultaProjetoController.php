<?php

namespace App\Modules\Projetos\Controllers;

use App\Modules\Projetos\Contracts\Business\DocumentoBusinessContract;
use App\Modules\Projetos\Contracts\Business\ObservacaoBusinessContract;
use App\Modules\Projetos\Contracts\Business\PlanoTesteBusinessContract;
use App\Modules\Projetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\Projetos\DTOs\ProjetoDTO;
use App\Modules\Projetos\Enums\PermissionEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Http\Controllers\Controller;
use App\System\Utils\EquipeUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class ConsultaProjetoController extends Controller
{
    public function __construct(
        private readonly ProjetoBusinessContract $projetoBusiness
    )
    {
    }

    public function getProjetosByAplicacao(int $idAplicacao)
    {

        try{
            $projetos = $this->projetoBusiness->buscarTodosPorAplicacao($idAplicacao, EquipeUtils::equipeUsuarioLogado());

            return response()->json($projetos);
        }catch (NotFoundException $exception){
            return response()->json([Controller::MESSAGE_KEY_ERROR => ['Aplicação não encontrada']], 404);
        }
    }

//    public function inserir(int $idAplicacao){
//        Auth::user()->can(PermissionEnum::INSERIR_PROJETO->value);
//        return view('projetos::projetos.inserir',compact('idAplicacao'));
//    }
//
//    public function salvar(Request $request, int $idAplicacao){
//        try{
//            Auth::user()->can(PermissionEnum::INSERIR_PROJETO->value);
//            $projetoDTO = ProjetoDTO::from($request->all());
//            $projetoDTO->aplicacao_id = $idAplicacao;
//            $this->projetoBusiness->inserir($projetoDTO);
//            return redirect(route('aplicacoes.projetos.index',$idAplicacao))
//                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Projeto inserido com sucesso!']]);
//        }catch (UnprocessableEntityException $exception){
//            return redirect(route('aplicacoes.projetos.inserir',$idAplicacao))
//                ->withErrors($exception->getValidator())
//                ->withInput();
//        }
//
//    }
//    public function editar(Request $request,int $idAplicacao, int $idProjeto)
//    {
//        Auth::user()->can(PermissionEnum::ALTERAR_PROJETO->value);
//        try{
//            $planosTeste = $this->planoTesteBusiness->buscarPlanosTestePorProjeto($idProjeto,EquipeUtils::equipeUsuarioLogado() );
//            $headsPlanoTeste = [
//                ['label' => 'Id', 'width' => 10],
//                'Título',
//                ['label' => 'Ações', 'width' => 20],
//            ];
//
//            $configPlanoTeste = [
//                ...config('adminlte.datatable_config'),
//                'searching' => false,
//                'columns' => [null, null, null, ['orderable' => false]],
//            ];
//            $documentos = $this->documentoBusiness->buscarTodosPorProjeto($idProjeto, EquipeUtils::equipeUsuarioLogado());
//            $observacoes = $this->observacaoBusiness->buscarPorProjeto($idProjeto);
//            $projeto = $this->projetoBusiness->buscarPorAplicacaoEProjeto($idAplicacao, $idProjeto, EquipeUtils::equipeUsuarioLogado());
//            return view(
//                'projetos::projetos.alterar',
//                compact(
//                    'projeto',
//                    'observacoes',
//                    'documentos',
//                    'planosTeste',
//                    'configPlanoTeste',
//                    'headsPlanoTeste'
//                ));
//        }catch (NotFoundException $exception){
//            return redirect(route('aplicacoes.projetos.index',$idAplicacao))
//                ->with([Controller::MESSAGE_KEY_ERROR => ['Projeto não encontrado']]);
//        }
//
//    }
//    public function atualizar(Request $request,int $idAplicacao, int $idProjeto)
//    {
//        Auth::user()->can(PermissionEnum::ALTERAR_PROJETO->value);
//        try{
//            $projetoDTO = ProjetoDTO::from($request->toArray());
//            $projetoDTO->aplicacao_id = $idAplicacao;
//            $projetoDTO->id = $idProjeto;
//            $this->projetoBusiness->atualizar($projetoDTO);
//            return redirect(route('aplicacoes.projetos.editar',[$idAplicacao, $idProjeto]))
//                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Projeto alterado com sucesso!']]);
//        }catch (NotFoundException $exception){
//            return redirect(route('aplicacoes.projetos.index',$idAplicacao))
//                ->with([Controller::MESSAGE_KEY_ERROR => ['Projeto não encontrado']]);
//        }catch (UnprocessableEntityException $exception){
//            return redirect(route('aplicacoes.projetos.editar',[$idAplicacao, $idProjeto]))
//                ->withErrors($exception->getValidator())
//                ->withInput();
//        }
//
//    }
//    public function excluir(Request $request,int $idAplicacao, int $idProjeto){
//        Auth::user()->can(PermissionEnum::REMOVER_PROJETO->value);
//        try{
//            $this->projetoBusiness->excluir($idAplicacao, $idProjeto);
//            return redirect(route('aplicacoes.projetos.index',$idAplicacao))
//                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Projeto removido com sucesso']]);
//        }catch (NotFoundException $exception){
//            return redirect(route('aplicacoes.projetos.index',$idAplicacao))
//                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
//        }
//    }
}
