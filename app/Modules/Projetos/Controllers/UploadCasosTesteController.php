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
             $this->casoTesteBusiness->importFile($request->file('arquivo'), $idPlanoTeste);
             return redirect(route('aplicacoes.projetos.planos-teste.visualizar', [$idAplicacao, $idProjeto, $idPlanoTeste]))
                 ->with([Controller::MESSAGE_KEY_SUCCESS => ['Arquivo importado com sucesso']]);
         }catch (NotFoundException $exception) {
             return redirect(route('aplicacoes.index'))
                 ->with([Controller::MESSAGE_KEY_ERROR => ['Plano de teste não encontrado']]);
         }
//         }catch (UnprocessableEntityException $exception){
//             return redirect(route('aplicacoes.editar', $id))
//                 ->withErrors($exception->getValidator())
//                 ->withInput();
//         }


     }
}
