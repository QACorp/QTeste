<?php

namespace App\System\Helpers;

use Illuminate\Support\Collection;

class DateHelper
{
    public static function getCollectionMeses(): Collection
    {
        return Collection::make([
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro',
        ]);
    }
}
