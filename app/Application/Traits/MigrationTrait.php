<?php

namespace App\Application\Traits;

trait MigrationTrait
{
    public function getTableName(string $tableName, string $schema = 'public'):string
    {
        return sprintf('%s.%s',$schema, $tableName);
    }
}
