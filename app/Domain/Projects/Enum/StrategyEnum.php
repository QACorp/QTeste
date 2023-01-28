<?php

namespace App\Domain\Projects\Enum;

use App\Application\Traits\EnumTrait;

enum StrategyEnum:string
{
    use EnumTrait;
    case GITFLOW = 'GitFlow';
    case PULLREQUEST = 'PullRequest';

}
