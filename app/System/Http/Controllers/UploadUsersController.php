<?php

namespace App\System\Http\Controllers;

use App\Modules\Projetos\Contracts\Business\CasoTesteBusinessContract;
use App\System\Contracts\Business\UserBusinessContract;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Http\Controllers\Controller;
use App\System\Utils\EquipeUtils;
use Illuminate\Http\Request;
use http\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UploadUsersController extends Controller
{
     public function __construct(
         private UserBusinessContract $userBusiness
     )
     {
     }
     public function uploadArquivoExcelParaUsers(Request $request)
     {
         try {
             $this->userBusiness->importarArquivoParaUser($request->file('arquivo'));
             return redirect(route('users.index'))
                 ->with([Controller::MESSAGE_KEY_SUCCESS => ['Arquivo importado com sucesso']]);
         }catch (FileException $exception) {
             return redirect(route('users.index'))
                 ->with([Controller::MESSAGE_KEY_ERROR => ['Arquivo no formato errado']]);
         }catch (UnprocessableEntityException $exception){
             return redirect(route('users.index'))
                 ->withErrors($exception->getValidator())
                 ->with([Controller::MESSAGE_KEY_ERROR => ['Houve um erro ao processar o arquivo, verifique se os usuários do arquivo já não existe na base de dados']])
                 ->withInput();
         }
     }
}
