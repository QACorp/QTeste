<?php

namespace App\Modules\GestaoEquipe\Repositories;

use App\Modules\GestaoEquipe\Contracts\Repository\RetrabalhoRepositoryContract;
use App\Modules\GestaoEquipe\DTOs\RelatorioRetrabalhosDTO;
use \App\Modules\Retrabalhos\Repositorys\RetrabalhoRepository as RetrabalhoRepositoryBase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RetrabalhoRepository extends RetrabalhoRepositoryBase implements RetrabalhoRepositoryContract
{
    public function getConditionData(?Carbon $inicio, ?Carbon $termino):string
    {
        if($inicio && $termino)
        {
            return " AND data between :inicio AND :termino";
        }
        if ($inicio)
        {
            return " AND data >= :inicio";
        }
        if ($termino)
        {
            return " AND data <= :termino";
        }
        return '';
    }
    public function buscarRetrabalhosUsuario(int $idUsuario, int $idEquipe, ?Carbon $inicio, ?Carbon $termino): RelatorioRetrabalhosDTO
    {
        $bidings = [':idUsuario' => $idUsuario];
        if ($inicio){
            $bidings[':inicio'] = $inicio;
        }
        if ($termino){
            $bidings[':termino'] = $termino;
        }
        $query = "SELECT
                    (SELECT
                         COUNT(*) FROM projetos.retrabalhos
                     WHERE usuario_id = :idUsuario
                       ".$this->getConditionData($inicio, $termino).") AS total_retrabalhos,
                    (SELECT
                        COUNT(DISTINCT checkpoints.tarefa_id)
                     FROM gestao_equipes.checkpoints
                     WHERE user_id = :idUsuario
                        ".$this->getConditionData($inicio, $termino).") AS total_tarefas,
                    (SELECT
                        COUNT(DISTINCT checkpoints.projeto_id)
                     FROM gestao_equipes.checkpoints
                     WHERE user_id = :idUsuario
                        ".$this->getConditionData($inicio, $termino).") AS total_projetos";
        $resultado = DB::select($query, $bidings);
        return RelatorioRetrabalhosDTO::from($resultado[0]);
    }
}
