<?php

namespace App\System\Impl;

use Illuminate\Support\Facades\DB;

abstract class BaseRepository implements BaseRepositoryContract
{
    public function beginTransaction():void{
        DB::beginTransaction();
    }

    public function commit():void{
        DB::commit();
    }

    public function rollback():void{
        DB::rollBack();
    }
}
