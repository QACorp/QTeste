<?php

namespace App\Domain\Projects\Enum;

use App\Application\Traits\EnumTrait;

Enum BranchEnum:string
{
    use EnumTrait;
    case MAIN = 'master';
    case DEVELOP = 'develop';
    case HOTFIX = 'hotfix';
    case FEATURE = 'feature';
    case RELEASE = 'release';

}
