<?php

namespace App\Modules\Projetos\Controllers;

use App\Modules\Projetos\Contracts\Business\AplicacaoBusinessContract;
use App\Modules\Projetos\Contracts\Business\CasoTesteBusinessContract;
use App\Modules\Projetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\Projetos\DTOs\ProjetoDTO;
use App\System\Services\Qara\DTOs\QAraMessageDTO;
use App\System\Services\Qara\QAra;
use App\System\Services\Qara\QAraCasosTesteModel;
use App\System\Services\Qara\QAraRoleEnum;
use App\System\Utils\EquipeUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class QAraController
{
    public function __construct(
        private readonly AplicacaoBusinessContract $aplicacaoBusiness,
        private readonly ProjetoBusinessContract $projetoBusiness,
        private readonly CasoTesteBusinessContract $casoTesteBusiness
    )
    {
    }

    public function gerarTexto(Request $request){

        $casosTeste = QAraCasosTesteModel::gerarTexto(QAraMessageDTO::from([
                'role' => QAraRoleEnum::USER,
                'content' => $request->get('requisitos')
            ])
        );
        dd($casosTeste);
    }
    public function index(Request $request)
    {
        $idAplicacao = $request->get('idAplicacao');
        $idProjeto = $request->get('idProjeto');
        $aplicacoes = $this->aplicacaoBusiness->buscarTodos(EquipeUtils::equipeUsuarioLogado());
        $projetos = Collection::empty();
        if($idAplicacao){
            $projetos = $this->projetoBusiness->buscarTodosPorAplicacao($idAplicacao, EquipeUtils::equipeUsuarioLogado());
        }
        return view('projetos::qara.index', compact(
                    'aplicacoes', 'idAplicacao', 'idProjeto', 'projetos'
            )
        );
    }
}
