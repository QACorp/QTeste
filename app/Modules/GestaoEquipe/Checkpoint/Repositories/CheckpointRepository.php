<?php

namespace App\Modules\GestaoEquipe\Checkpoint\Repositories;

use App\Modules\GestaoEquipe\Checkpoint\Contracts\Respositories\CheckpointRepositoryContract;
use App\Modules\GestaoEquipe\Checkpoint\DTOs\CheckpointDTO;
use App\Modules\GestaoEquipe\Checkpoint\Models\Checkpoint;
use App\Modules\GestaoEquipe\Helpers\QueryDataHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Spatie\LaravelData\DataCollection;

class CheckpointRepository implements CheckpointRepositoryContract
{

    public function create(CheckpointDTO $checkpointDTO, int $idEquipe): CheckpointDTO
    {
        $checkpoint = new Checkpoint($checkpointDTO->toArray());
        $checkpoint->save();
        return CheckpointDTO::from($checkpoint);
    }

    public function update(CheckpointDTO $checkpointDTO): CheckpointDTO
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id): bool
    {
        // TODO: Implement delete() method.
    }

    public function list(int $idEquipe): DataCollection
    {
        return new DataCollection(CheckpointDTO::class, []);
    }

    public function getCheckpoint(int $id): CheckpointDTO
    {
        // TODO: Implement getCheckpoint() method.
    }

    public function getLastCheckpoint(int $idEquipe, int $idUsuario): ?CheckpointDTO
    {
        $checkpoint = Checkpoint::select('checkpoints.*')
                                ->where('equipe_id', $idEquipe)
                                ->where('user_id', $idUsuario)
                                ->orderBy('data', 'desc')
                                ->orderBy('id', 'desc')
                                ->with('projeto','user', 'criador', 'projeto.aplicacao', 'alocacao', 'tarefa')
                                ->first();
        return $checkpoint ? CheckpointDTO::from($checkpoint) : null;
    }

    public function listarCheckpointPorAlocacao(int $idEquipe, int $idAlocacao): DataCollection
    {
        $checkpoint = Checkpoint::select('checkpoints.*')
            ->where('equipe_id', $idEquipe)
            ->where('alocacao_id', $idAlocacao)
            ->orderBy('data', 'desc')
            ->orderBy('id', 'desc')
            ->with('projeto','user', 'criador', 'projeto.aplicacao', 'alocacao', 'tarefa')
            ->get();
        return CheckpointDTO::collection($checkpoint);
    }
    private function getCheckpointPorUsuarioBuilder(int $idEquipe, int $idUsuario): Builder
    {
        return Checkpoint::select('checkpoints.*')
            ->where('equipe_id', $idEquipe)
            ->where('user_id', $idUsuario)
            ->orderBy('data', 'desc')
            ->orderBy('id', 'desc')
            ->with('projeto','user', 'criador', 'projeto.aplicacao', 'alocacao', 'tarefa');
    }
    public function listarCheckpointPorUsuario(int $idEquipe, int $idUsuario): DataCollection
    {
        $checkpoint = $this->getCheckpointPorUsuarioBuilder($idEquipe, $idUsuario)->get();
        return CheckpointDTO::collection($checkpoint);
    }

    public function listarCheckpointPorUsuarioEData(int $idEquipe, int $idUsuario, ?Carbon $inicio, ?Carbon $termino): DataCollection
    {
        $builder = $this->getCheckpointPorUsuarioBuilder($idEquipe, $idUsuario);
        QueryDataHelper::addFilterInicioTermino($builder, $inicio, $termino);
        $checkpoint = $builder->get();
        return CheckpointDTO::collection($checkpoint);
    }
}
