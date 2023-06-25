<?php

namespace App\System\Repositorys;

use App\System\Contracts\Repository\EquipeRepositoryContract;
use App\System\DTOs\EquipeDTO;
use App\System\Models\Equipe;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class EquipeRepository implements EquipeRepositoryContract
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
}
