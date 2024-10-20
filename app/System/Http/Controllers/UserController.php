<?php

namespace App\System\Http\Controllers;

use App\System\Contracts\Business\UserBusinessContract;
use App\System\DTOs\RoleDTO;
use App\System\DTOs\UserDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Traits\Authverification;
use App\System\Traits\EquipeTools;
use App\System\Utils\EquipeUtils;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Spatie\LaravelData\DataCollection;

class UserController extends Controller
{
    use Authverification, EquipeTools;
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
        $user = $this->userBusiness->buscarPorId($idUsuario, EquipeUtils::equipeUsuarioLogado());
        $user->equipes->each(function($item, $key) use(&$idsEquipe){
            $idsEquipe[] = $item->id;
        });
        return view('users.alterar', [...compact('user', 'idsEquipe'),'userController' => $this]);
    }
    public function atualizar(Request $request, int $idUsuario)
    {

        try {
            $userDTO = UserDTO::from([
                ...$request->only(['name', 'email']),
                'id' => $idUsuario,
                'active' => $request->has('active') ? true : false,
                'roles' => $this->converterArrayEmRoleDTO($request->roles)

            ]);
            $userDTO->equipes = $this->convertArrayEquipeInDTO($request->only('equipes'));
            $this->userBusiness->alterar($userDTO, EquipeUtils::equipeUsuarioLogado());
            return redirect(route('users.index'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Usuário alterado com sucesso']]);
        }catch (NotFoundException $exception){
            return redirect(route('users.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
        }catch (UnprocessableEntityException $exception){
            return redirect(route('users.editar', $idUsuario))
                ->withErrors($exception->getValidator())
                ->withInput();
        }
    }
    public function editarSenha(Request $request, int $idUsuario)
    {
        $user = $this->userBusiness->buscarPorId($idUsuario, EquipeUtils::equipeUsuarioLogado());
        return view('users.alterar-senha',compact('user'));
    }

    public function atualizarSenha(Request $request, int $idUsuario)
    {
        try {
            $userDTO = UserDTO::from([
                ...$request->only(['password', 'password_confirmation']),
                'id' => $idUsuario
            ]);

            $this->userBusiness->alterarSenha($userDTO, EquipeUtils::equipeUsuarioLogado());

            return redirect(route('users.index'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Usuário alterado com sucesso']]);
        }catch (NotFoundException $exception){
            return redirect(route('users.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
        }catch (UnprocessableEntityException $exception){

            return redirect(route('users.alterar-senha', $idUsuario))
                ->withErrors($exception->getValidator())
                ->withInput();
        }
    }
    public function editarSenhaUsuarioLogado(Request $request)
    {
        $user = Auth::user();

        return view('users.alterar-senha-usuario-logado',compact('user'));
    }
    public function atualizarSenhaUsuarioLogado(Request $request)
    {
        try {
            $userDTO = UserDTO::from([
                ...$request->only(['password', 'password_confirmation']),
                'id' => Auth::user()->getAuthIdentifier()
            ]);

            $this->userBusiness->alterarSenha($userDTO, EquipeUtils::equipeUsuarioLogado());

            return redirect(route('users.alterar-senha-usuario-logado'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Usuário alterado com sucesso']]);
        }catch (UnprocessableEntityException $exception){

            return redirect(route('users.alterar-senha-usuario-logado'))
                ->withErrors($exception->getValidator())
                ->withInput();
        }
    }
    public function inserir(Request $request)
    {

        return view('users.inserir', ['userController' => $this]);
    }

    public function salvar(Request $request)
    {
        try {
            $userDTO = UserDTO::from([
                ...$request->only(['name', 'email']),
                'roles' => $this->converterArrayEmRoleDTO($request->roles),
                'active' => $request->has('active')
            ]);
            $userDTO->equipes = $this->convertArrayEquipeInDTO($request->only('equipes'));
            $this->userBusiness->salvar($userDTO);
            return redirect(route('users.index'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Usuário inserido com sucesso']]);
        }catch (UnprocessableEntityException $exception){
            return redirect(route('users.inserir'))
                ->withErrors($exception->getValidator())
                ->withInput();
        }

    }
    private function converterArrayEmRoleDTO(array $roles): DataCollection
    {
        $collectionRoles = [];
        foreach ($roles as $role){
            $collectionRoles[] = ['name' => $role];
        }
        return RoleDTO::collection($collectionRoles);
    }
    public function convertArrayRoleDTO(array $lista):array
    {
        $roles = [];
        foreach ($lista as $item){
            if($item instanceof RoleDTO)
                $roles[] = $item;
            else
                $roles[] = RoleDTO::from(['name' => $item]);
        }
        return $roles;
    }
    public function alterarEquipeCookie(Request $request, int $idEquipe)
    {
        if(!$this->userMembroEquipe($idEquipe)){
            throw new UnauthorizedException(403);
        }
        $this->userBusiness->alterarEquipeSelecionada(Auth::user()->id, $idEquipe);
        return redirect()->back();
    }
}
