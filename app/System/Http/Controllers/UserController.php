<?php

namespace App\System\Http\Controllers;

use App\System\Contracts\UserBusinessContract;
use App\System\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly UserBusinessContract $userBusiness
    )
    {
    }

    public function index()
    {
        $users = $this->userBusiness->buscarTodos();

        $heads = [
            ['label' => 'Id', 'width' => 10],
            ['label' => 'Nome', 'width' => 25],
            ['label' => 'E-mail', 'width' => 25],
            ['label' => 'Perfil', 'width' => 15],
            ['label' => 'Ações', 'width' => 20],
        ];

        $config = [
            ...config('adminlte.datatable_config'),
            'columns' => [null, null, null, null, ['orderable' => false]],
        ];
        return view('users.home', compact('users','heads', 'config'));
    }
    public function editar(Request $request, int $idUsuario)
    {
        $user = $this->userBusiness->buscarPorId($idUsuario);
        return view('users.alterar', compact('user'));
    }

    public function atualizar(Request $request, int $idUsuario)
    {
        dd($request->roles);
    }
}
