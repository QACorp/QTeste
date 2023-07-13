<?php

namespace App\System\Impl;

use Illuminate\Support\Facades\DB;

interface BaseRepositoryContract
{
    public function beginTransaction():void;

    public function commit():void;

    public function rollback():void;
}
