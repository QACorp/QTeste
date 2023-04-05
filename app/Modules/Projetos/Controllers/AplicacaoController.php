<?php

namespace App\Modules\Projetos\Controllers;

use App\Modules\Projetos\Contracts\AplicacaoBusinessContract;
use App\Modules\Projetos\Models\Aplicacao;
use App\System\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

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
}
