<?php

namespace App\Domain\Projects\Configuration;

use App\Application\Abstracts\DomainConfigurationAbstract;

class DomainConfigurationProject extends DomainConfigurationAbstract
{

    public static function getDatabaseSchema(): string
    {
        return 'project';
    }
}
