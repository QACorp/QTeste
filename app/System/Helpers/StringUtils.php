<?php

namespace App\System\Helpers;

use Illuminate\Support\Collection;

class StringUtils
{
    static public function array2String(array $collection, string $field):string
    {
        $stringReturnable = array();
        foreach ($collection as $item){
            $stringReturnable[] = $item[$field];
        }
        return implode(', ', $stringReturnable);
    }
}
