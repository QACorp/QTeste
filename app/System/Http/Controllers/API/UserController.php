<?php

namespace App\System\Http\Controllers\API;

use App\System\Contracts\Business\UserBusinessContract;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly UserBusinessContract $userBusiness
    )
    {
    }
    public function getUserByEquipe(Request $request, int $idEquipe){
        return response()->json($this->userBusiness->buscarUsuariosPorEquipe($idEquipe, 'api'));
    }

    public function getPermissions(Request $request){
        return response()->json($this->userBusiness->getPermissionsPorUsuarioLogado()->only('name'));
    }
    public function getUserById(Request $request, int $idUser){

        try{
            if (!$request->get('idEquipe')){
                return response()->json(['message' => 'Equipe não informada'], 400);
            }
            return response()->json($this->userBusiness->buscarPorId($idUser, $request->get('idEquipe')));
        }catch (UnauthorizedException | NotFoundException $e){
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

    }
}
