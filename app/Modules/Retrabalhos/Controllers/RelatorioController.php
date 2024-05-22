<?php

namespace App\Modules\Retrabalhos\Controllers;

use App\Modules\Retrabalhos\Contracts\Business\RelatorioBusinessContract;
use App\Modules\Retrabalhos\DTOs\FiltrosDTO;
use App\System\Http\Controllers\Controller;
use App\System\Utils\EquipeUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RelatorioController extends Controller
{
    public function __construct(
        private readonly RelatorioBusinessContract $relatorioBusiness
    )
    {
    }

    public function index(Request $request)
    {
        return view('retrabalhos::relatorios.home');
    }

    public function porDesenvolvedor(Request $request)
    {
        $filtros = new FiltrosDTO();
        $filtros->dataInicio = $request->get('dtInicio') ? Carbon::make($request->get('dtInicio')) : Carbon::now()->startOfMonth();
        $filtros->dataFim = $request->get('dtFim') ? Carbon::make($request->get('dtFim')) : Carbon::now()->endOfMonth();
        $retrabalhos = $this->relatorioBusiness->relatorioRetrabalhoDesenvolvedor($filtros, EquipeUtils::equipeUsuarioLogado());
        $heads = [
            '#',
            ['label' => 'Nome', 'width' => 20],
            'Qtde. Tarefas',
            'Qtde. Retrabalhos',
            'Proporção. Retrabalhos',
            'Qtde. Ret. Análise',
            'Proporção Ret. Análise',
            'Qtde. Ret. Funcional',
            'Proporção Ret. Funcional',
        ];

        $config = [
            ...config('adminlte.datatable_config'),
            'columns' => [['orderable' => true], ['orderable' => true], ['orderable' => true], ['orderable' => true], ['orderable' => true], ['orderable' => true], ['orderable' => true], ['orderable' => true], ['orderable' => true] ],
        ];
        return view('retrabalhos::relatorios.desenvolvedor',
            array_merge(compact('retrabalhos', 'heads', 'config', 'filtros'),['dtInicio' => $filtros->dataInicio->format('Y-m-d'), 'dtFim' => $filtros->dataFim->format('Y-m-d') ])
        );
    }

    public function porTarefa(Request $request)
    {
        $filtros = new FiltrosDTO();
        $filtros->dataInicio = $request->get('dtInicio') ? Carbon::make($request->get('dtInicio')) : Carbon::now()->startOfMonth();
        $filtros->dataFim = $request->get('dtFim') ? Carbon::make($request->get('dtFim')) : Carbon::now()->endOfMonth();
        $retrabalhos = $this->relatorioBusiness->relatorioRetrabalhoTarefa($filtros, EquipeUtils::equipeUsuarioLogado());
        $heads = [
            ['label' => 'Tarefa', 'width' => 10],
            'Qtde. Retrabalhos',
            'Qtde. Ret. Análise',
            'Proporção Ret. Análise',
            'Qtde. Ret. Funcional',
            'Proporção Ret. Funcional',
        ];

        $config = [
            ...config('adminlte.datatable_config'),

            'columns' => [
                ['orderable' => true],
                ['orderable' => true],
                ['orderable' => true],
                ['orderable' => true],
                ['orderable' => true],
                ['orderable' => true]
            ],
        ];
        return view('retrabalhos::relatorios.tarefa',
            array_merge(compact('retrabalhos', 'heads', 'config', 'filtros'),['dtInicio' => $filtros->dataInicio->format('Y-m-d'), 'dtFim' => $filtros->dataFim->format('Y-m-d') ])
        );
    }
    public function porAplicacao(Request $request)
    {
        $filtros = new FiltrosDTO();
        $filtros->dataInicio = $request->get('dtInicio') ? Carbon::make($request->get('dtInicio')) : Carbon::now()->startOfMonth();
        $filtros->dataFim = $request->get('dtFim') ? Carbon::make($request->get('dtFim')) : Carbon::now()->endOfMonth();
        $retrabalhos = $this->relatorioBusiness->relatorioRetrabalhoAplicacao($filtros, EquipeUtils::equipeUsuarioLogado());
        $heads = [
            ['label' => '#', 'width' => 5],
            ['label' => 'nome', 'width' => 10],
            'Qtde. Tarefas',
            'Qtde. Retrabalhos',
            'Proporção. Ret.',
            'Qtde. Ret. Análise',
            'Proporção Ret. Análise',
            'Qtde. Ret. Funcional',
            'Proporção Ret. Funcional',
        ];

        $config = [
            ...config('adminlte.datatable_config'),

            'columns' => [
                ['orderable' => true],
                ['orderable' => true],
                ['orderable' => true],
                ['orderable' => true],
                ['orderable' => true],
                ['orderable' => true],
                ['orderable' => true],
                ['orderable' => true],
                ['orderable' => true],
            ],
        ];
        return view('retrabalhos::relatorios.aplicacao',
            array_merge(compact('retrabalhos', 'heads', 'config', 'filtros'),['dtInicio' => $filtros->dataInicio->format('Y-m-d'), 'dtFim' => $filtros->dataFim->format('Y-m-d') ])
        );
    }
    public function meusRetrabalhos(Request $request)
    {
        $filtros = new FiltrosDTO();
        $filtros->dataInicio = $request->get('dtInicio') ? Carbon::make($request->get('dtInicio')) : Carbon::now()->startOfMonth();
        $filtros->dataFim = $request->get('dtFim') ? Carbon::make($request->get('dtFim')) : Carbon::now()->endOfMonth();
        $retrabalhos = $this->relatorioBusiness->relatorioMeusRetrabalhos($filtros, Auth::user()->getAuthIdentifier());
        $heads = [
            '#',
            'Tarefa',
            'Data',
            ['label' => 'Criador', 'width' => 20],
            'Aplicação',
            'Projeto'
        ];

        $config = [
            ...config('adminlte.datatable_config'),
            'columns' => [['orderable' => true], ['orderable' => true], ['orderable' => true], ['orderable' => true], ['orderable' => true], ['orderable' => true] ],
        ];
        return view('retrabalhos::relatorios.meus-retrabalhos',
            array_merge(compact('retrabalhos', 'heads', 'config', 'filtros'),['dtInicio' => $filtros->dataInicio->format('Y-m-d'), 'dtFim' => $filtros->dataFim->format('Y-m-d') ])
        );
    }
}
