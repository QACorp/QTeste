<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\Repository\UsuarioComMaisExecucoesRepositoryContract;
use App\Modules\Projetos\DTOs\UsuarioComMaisExecucoesDTO;
use App\System\Impl\BaseRepository;
use App\System\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class UsuarioComMaisExecucoesRepository extends BaseRepository  implements UsuarioComMaisExecucoesRepositoryContract extends BaseRepositoryContract
{

    public function buscarUsuarioPorOrdemExecucao(int $limit, int $idEquipe): DataCollection
    {
        return UsuarioComMaisExecucoesDTO::collection(
            User::select(DB::raw('DISTINCT users.id, users.*,
                (SELECT
                     COUNT(id)
                 FROM
                     projetos.caso_teste_execucoes cte2
                 WHERE
                    cte2.user_id = users.id AND
                    resultado is not null AND
                    cte2.equipe_id = caso_teste_execucoes.equipe_id) as total_execucoes'))
                ->orderBy('total_execucoes','DESC')
                ->join('users_equipes', 'users_equipes.user_id','=', 'users.id' )
                ->join('projetos.caso_teste_execucoes', 'caso_teste_execucoes.user_id', '=', 'users.id')
                ->where('caso_teste_execucoes.equipe_id', $idEquipe)
                ->limit($limit)
                ->get()
        );
    }
}
