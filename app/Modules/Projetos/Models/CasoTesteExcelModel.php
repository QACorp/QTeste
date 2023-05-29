<?php

namespace App\Modules\Projetos\Models;

use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\Enums\CasoTesteEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class CasoTesteExcelModel implements ToModel
{

    public function model(array $row)
    {
        if (!isset($row[1]) || $row[0] == 'Tipo') {
            return null;
        }

        return new CasoTeste([
            'titulo' => $row[1],
            'requisito' => $row[1],
            'cenario' => $row[2],
            'teste' => $row[3],
            'resultado_esperado' => $row[5],
            'status' => CasoTesteEnum::CONCLUIDO->value
        ]);
    }
//    public function collection(Collection $collection)
//    {
//        $casosTeste = [];
//        $collection->each(function($row, $key) use(&$casosTeste){
//            $casosTeste[] = CasoTesteDTO::from([
//                'titulo' => $row[1],
//                'requisito' => $row[1],
//                'cenario' => $row[2],
//                'teste' => $row[3],
//                'resultado_esperado' => $row[5],
//                'status' => CasoTesteEnum::CONCLUIDO->value
//            ]);
//        });
//        return Collection::make($casosTeste);
//    }
}
