<?php

namespace App\Modules\Projetos\Controllers;

use App\Modules\Projetos\Contracts\AplicacaoBusinessContract;
use App\Modules\Projetos\DTOs\AplicacaoDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Http\Controllers\Controller;
use Illuminate\Http\Request;


class AplicacaoController extends Controller
{
    public static $HEADS_TABLE = ['name','description'];
    public function __construct(
        private readonly AplicacaoBusinessContract $aplicacaoBusiness
    )
    {

    }
    public function index()
    {
        $aplicacoes = $this->aplicacaoBusiness->buscarTodos();

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
        return view('projetos::aplicacoes.home',
            compact('heads', 'config', 'aplicacoes'));
    }

    public function inserir()
    {
        return view('projetos::aplicacoes.inserir');
    }

    public function salvar(Request $request)
    {
        try {
            $this->aplicacaoBusiness->salvar(AplicacaoDTO::from($request->all()));
            return redirect(route('aplicacoes.index'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Aplicação inserida com sucesso']]);
        }catch (UnprocessableEntityException $exception){
            return redirect(route('aplicacoes.inserir'))
                ->withErrors($exception->getValidator())
                ->withInput();
        }
    }

    public function editar(Request $request, int $id)
    {
        try{
            $aplicacao = $this->aplicacaoBusiness->buscarPorId($id);
            return view('projetos::aplicacoes.alterar',compact('aplicacao'));
        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
        }

    }

    public function atualizar(Request $request, int $id)
    {
        try{
            $aplicacaoDTO = AplicacaoDTO::from($request->all());
            $aplicacaoDTO->id = $id;
            $this->aplicacaoBusiness->alterar($aplicacaoDTO);
            return redirect(route('aplicacoes.index'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Aplicação alterada com suncesso']]);
        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
        }catch (UnprocessableEntityException $exception){
            return redirect(route('aplicacoes.editar', $id))
                ->withErrors($exception->getValidator())
                ->withInput();
        }
    }
    public function excluir(Request $request, $id)
    {
        try{
            $this->aplicacaoBusiness->excluir($id);
            return redirect(route('aplicacoes.index'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Aplicação removida com sucesso']]);
        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
        }
    }
}
