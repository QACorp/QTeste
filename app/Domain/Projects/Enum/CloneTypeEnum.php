<?php

namespace App\Domain\Projects\Enum;

use App\Application\Traits\EnumTrait;

enum CloneTypeEnum:string
{
    use EnumTrait;
    case SSH = 'SSH';
    case HTTP = 'HTTP';


}
