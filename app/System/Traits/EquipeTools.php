<?php

namespace App\System\Traits;

use App\System\DTOs\EquipeDTO;
use Spatie\LaravelData\DataCollection;

trait EquipeTools
{
    public function convertArrayEquipeInDTO(array $equipes): DataCollection
    {
        $ids = [];
        foreach ($equipes['equipes'] as $equipe) {
            $ids[] = ['id' => $equipe];
        }
        return EquipeDTO::collection($ids);
    }
}
