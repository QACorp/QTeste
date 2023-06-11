<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\UsuarioComMaisExecucoesRepositoryContract;
use App\Modules\Projetos\DTOs\TestesMaisExecutadosDTO;
use App\Modules\Projetos\DTOs\UsuarioComMaisExecucoesDTO;
use App\Modules\Projetos\Models\CasoTeste;
use App\System\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class UsuarioComMaisExecucoesRepository implements UsuarioComMaisExecucoesRepositoryContract
{

    public function buscarUsuarioPorOrdemExecucao(int $limit): DataCollection
    {
        return UsuarioComMaisExecucoesDTO::collection(
            User::select(DB::raw('*,
                (SELECT
                     COUNT(id)
                 FROM
                     projetos.caso_teste_execucoes cte2
                 WHERE cte2.user_id = users.id AND resultado is not null) as total_execucoes'))
                ->orderBy('total_execucoes','DESC')
                ->limit($limit)
                ->get()
        );
    }
}
