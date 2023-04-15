<?php

namespace App\Modules\Projetos\Controllers;

use App\Modules\Projetos\Contracts\ProjetoBusinessContract;
use App\System\Exceptions\NotFoundException;
use App\System\Http\Controllers\Controller;

class ProjetoController extends Controller
{
    public function __construct(
        private readonly ProjetoBusinessContract $projetoBusiness
    )
    {
    }

    public function index(int $id)
    {
        try{
            $projetos = $this->projetoBusiness->buscarTodosPorAplicacao($id);
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
            return view('projetos::projetos.home',compact('projetos', 'heads', 'config'));
        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Aplicação não encontrada']]);
        }

    }
}
