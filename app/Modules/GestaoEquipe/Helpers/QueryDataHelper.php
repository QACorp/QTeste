<?php

namespace App\Modules\GestaoEquipe\Helpers;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;

class QueryDataHelper
{
    public static function addFilterInicioTermino(Builder &$query, ?Carbon $inicio, ?Carbon $termino, string $fieldData = 'data'): void
    {
        if($inicio && !$termino){
            $query->where($fieldData, '>=', $inicio);
        }elseif($termino && !$inicio){
            $query->where($fieldData, '<=', $termino);
        }elseif($inicio && $termino){
            $query->whereBetween($fieldData, [$inicio, $termino]);
        }
    }
}
