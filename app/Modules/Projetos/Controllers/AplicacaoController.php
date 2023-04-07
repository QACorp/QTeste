<?php

namespace App\Modules\Projetos\Controllers;

use App\Modules\Projetos\Contracts\AplicacaoBusinessContract;
use App\Modules\Projetos\DTOs\AplicacaoDTO;
use App\Modules\Projetos\Requests\AplicacoesPostRequest;
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
        $data = [];
        foreach ($aplicacoes as $item) {
            $data[] = [$item->id, $item->nome, $item->descricao];
        }
        $heads = ['Id', 'Nome', 'Descrição'];

        $config = [
            'data' => $data
        ];
        return view('projetos::aplicacoes.home',compact('heads', 'config'));
    }

    public function inserir()
    {
        return view('projetos::aplicacoes.inserir');
    }

    public function salvar(AplicacoesPostRequest $request)
    {

        $aplicacao = $this->aplicacaoBusiness->salvar(AplicacaoDTO::from($request->all()));
        return redirect(route('aplicacoes.index'))
            ->with([Controller::MESSAGE_KEY_SUCESS => ['Aplicação inserida com suncesso']]);
    }
}
