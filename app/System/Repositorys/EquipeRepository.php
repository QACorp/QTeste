<?php

namespace App\System\Repositorys;

use App\System\Contracts\Repository\EquipeRepositoryContract;
use App\System\DTOs\EquipeDTO;
use App\System\Impl\BaseRepository;
use App\System\Models\Equipe;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class EquipeRepository extends BaseRepository  implements EquipeRepositoryContract
{

    public function buscarTodos(): DataCollection
    {
        return EquipeDTO::collection(
            Equipe::with('users')
                ->get()
        );
    }

    public function inserir(EquipeDTO $equipe): EquipeDTO
    {
        try {
            DB::beginTransaction();
            $equipeModel = new Equipe($equipe->only('nome')->toArray());
            $equipeModel->save();
            $usersMembersIds = [];
            $equipe->users->each(function ($item, $key) use (&$usersMembersIds) {
                $usersMembersIds[] = $item->id;
            });

            $equipeModel->users()->sync($usersMembersIds);
            $equipeModel->save();
            DB::commit();
            return EquipeDTO::from($equipeModel);
        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function buscarEquipePorId(int $idEquipe): ?EquipeDTO
    {
        $equipe = Equipe::with('users')
                    ->where('id', $idEquipe)
                    ->first();
        return $equipe == null ? $equipe : EquipeDTO::from($equipe);
    }

    public function alterar(EquipeDTO $equipe): EquipeDTO
    {
        try {
            DB::beginTransaction();
            $equipeModel = Equipe::find($equipe->id);
            $equipeModel->fill($equipe->only('nome')->toArray());
            $equipeModel->update();
            $usersMembersIds = [];

            $equipe->users->each(function ($item, $key) use (&$usersMembersIds) {
                $usersMembersIds[] = $item->id;
            });

            $equipeModel->users()->sync($usersMembersIds);
            DB::commit();
            return EquipeDTO::from($equipeModel);
        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }

    }
}
