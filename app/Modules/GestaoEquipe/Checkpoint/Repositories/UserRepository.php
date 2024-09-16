<?php

namespace App\Modules\GestaoEquipe\Checkpoint\Repositories;

use App\Modules\GestaoEquipe\Checkpoint\Contracts\Respositories\UserRepositoryContract;
use App\System\DTOs\UserDTO;
use App\System\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

class UserRepository extends \App\System\Repositorys\UserRepository implements UserRepositoryContract
{

    public function listarUsuariosPaginado(int $idEquipe, int $page = null, int $limit = null):DataCollection|PaginatedDataCollection
    {
        $buscar = User::join('users_equipes as ue', 'ue.user_id', '=', 'users.id')
                        ->where('ue.equipe_id', $idEquipe)
                        ->where('id', '<>', Auth::user()->getAuthIdentifier())
                        ->where('active', true);
        if($page && $limit){
            return UserDTO::collection($buscar->paginate($limit, ['*'], 'page', $page));
        }
        return UserDTO::collection($buscar->get());
    }
}
