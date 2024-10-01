<?php

namespace App\Modules\GestaoEquipe\Controllers;

use App\System\Contracts\Business\UserBusinessContract;
use App\System\Http\Controllers\Controller;
use App\System\Utils\EquipeUtils;
use Illuminate\Http\Request;


class GestaoEquipeController extends Controller
{
    public function __construct(
        private readonly UserBusinessContract $userBusiness
    )
    {
    }
    public function dashboard(Request $request, int $idUsuario)
    {
        $user = $this->userBusiness->buscarPorId($idUsuario, EquipeUtils::equipeUsuarioLogado());
        return view('gestao-equipe::dashboard', ['usuario' => $user]);
    }
}
