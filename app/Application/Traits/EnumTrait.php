<?php

namespace App\Application\Traits;

trait EnumTrait
{
    public static function values(): array
    {
        if(!method_exists(self::class,'cases'))
            throw new \Exception('This method is not permitible in the class!');
        return array_column(self::cases(), 'value');
    }
}
