<?php

namespace App\Application\Abstracts;

abstract class DomainConfigurationAbstract
{
    const DEFAULT_SCHEMA = 'public';
    public static function getDatabaseSchema():string
    {
        return self::DEFAULT_SCHEMA;
    }
}
