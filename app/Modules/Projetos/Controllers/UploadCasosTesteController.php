<?php

namespace App\Modules\Projetos\Controllers;

use App\Modules\Projetos\Contracts\CasoTesteBusinessContract;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadCasosTesteController extends Controller
{
     public function __construct(
         private CasoTesteBusinessContract $casoTesteBusiness
     )
     {
     }
     public function uploadArquivoExcelParaPlanoTeste(Request $request,int $idAplicacao, int $idProjeto, int $idPlanoTeste)
     {
         try {
             $this->casoTesteBusiness->importarArquivoParaPlanoTeste($request->file('arquivo'), $idPlanoTeste);
             return redirect(route('aplicacoes.projetos.planos-teste.visualizar', [$idAplicacao, $idProjeto, $idPlanoTeste]))
                 ->with([Controller::MESSAGE_KEY_SUCCESS => ['Arquivo importado com sucesso']]);
         }catch (NotFoundException $exception) {
             return redirect(route('aplicacoes.index'))
                 ->with([Controller::MESSAGE_KEY_ERROR => ['Plano de teste não encontrado']]);
         }catch (UnprocessableEntityException $exception){
             return redirect(route('aplicacoes.projetos.planos-teste.visualizar', [$idAplicacao, $idProjeto, $idPlanoTeste]))
                 ->withErrors($exception->getValidator())
                 ->with([Controller::MESSAGE_KEY_ERROR => ['Houve um erro ao processar o arquivo']])
                 ->withInput();
         }


     }

    public function uploadArquivoExcel(Request $request)
    {
        try {
            $this->casoTesteBusiness->importarArquivo($request->file('arquivo'));
            return redirect(route('aplicacoes.casos-teste.index'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Arquivo importado com sucesso']]);
        }catch (UnprocessableEntityException $exception){
            return redirect(route('aplicacoes.casos-teste.index'))
                ->withErrors($exception->getValidator())
                ->with([Controller::MESSAGE_KEY_ERROR => ['Houve um erro ao processar o arquivo']])
                ->withInput();
        }


    }
}
