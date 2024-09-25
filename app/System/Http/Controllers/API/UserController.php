<?php

namespace App\System\Http\Controllers\API;

use App\System\Contracts\Business\UserBusinessContract;
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
}
