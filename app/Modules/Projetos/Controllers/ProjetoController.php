<?php

namespace App\Modules\Projetos\Controllers;

use App\Modules\Projetos\Contracts\ObservacaoBusinessContract;
use App\Modules\Projetos\Contracts\ProjetoBusinessContract;
use App\Modules\Projetos\DTOs\ProjetoDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjetoController extends Controller
{
    public function __construct(
        private readonly ProjetoBusinessContract $projetoBusiness,
        private readonly ObservacaoBusinessContract $observacaoBusiness
    )
    {
    }

    public function index(int $idAplicacao)
    {
        try{
            $projetos = $this->projetoBusiness->buscarTodosPorAplicacao($idAplicacao);
            $heads = [
                ['label' => 'Id', 'width' => 10],
                'Nome',
                'Descrição',
                ['label' => 'Ações', 'width' => 20],
            ];

            $config = [
                ...config('adminlte.datatable_config'),
                'columns' => [null, null, null, ['orderable' => false]],
            ];
            return view('projetos::projetos.home',compact('idAplicacao','projetos', 'heads', 'config'));
        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Aplicação não encontrada']]);
        }
    }

    public function inserir(int $idAplicacao){
        return view('projetos::projetos.inserir',compact('idAplicacao'));
    }

    public function salvar(Request $request, int $idAplicacao){
        try{
            $projetoDTO = ProjetoDTO::from($request->all());
            $projetoDTO->aplicacao_id = $idAplicacao;
            $this->projetoBusiness->inserir($projetoDTO);
            return redirect(route('aplicacoes.projetos.index',$idAplicacao))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Projeto inserido com sucesso!']]);
        }catch (UnprocessableEntityException $exception){
            return redirect(route('aplicacoes.projetos.inserir',$idAplicacao))
                ->withErrors($exception->getValidator())
                ->withInput();
        }

    }
    public function editar(Request $request,int $idAplicacao, int $idProjeto)
    {
        try{
            $observacoes = $this->observacaoBusiness->buscarPorProjeto($idProjeto);
            $projeto = $this->projetoBusiness->buscarPorAplicacaoEProjeto($idAplicacao, $idProjeto);
            return view('projetos::projetos.alterar',compact('projeto','observacoes'));
        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.projetos.index',$idAplicacao))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Projeto não encontrado']]);
        }

    }
    public function atualizar(Request $request,int $idAplicacao, int $idProjeto)
    {
        try{
            $projetoDTO = ProjetoDTO::from($request->toArray());

            $projetoDTO->aplicacao_id = $idAplicacao;
            $projetoDTO->id = $idProjeto;
            $this->projetoBusiness->atualizar($projetoDTO);
            return redirect(route('aplicacoes.projetos.editar',[$idAplicacao, $idProjeto]))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Projeto alterado com sucesso!']]);
        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.projetos.index',$idAplicacao))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Projeto não encontrado']]);
        }catch (UnprocessableEntityException $exception){

            return redirect(route('aplicacoes.projetos.editar',[$idAplicacao, $idProjeto]))
                ->withErrors($exception->getValidator())
                ->withInput();
        }

    }
    public function excluir(Request $request,int $idAplicacao, int $idProjeto){
        try{

            $this->projetoBusiness->excluir($idAplicacao, $idProjeto);
            return redirect(route('aplicacoes.projetos.index',$idAplicacao))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Projeto removido com sucesso']]);
        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.projetos.index',$idAplicacao))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
        }
    }
}
