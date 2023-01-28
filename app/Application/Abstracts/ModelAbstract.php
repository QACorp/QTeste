<?php

namespace App\Application\Abstracts;

use App\Domain\Projects\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

abstract class ModelAbstract extends Model
{
    protected static function booted()
    {
        static::creating(fn( Model $clazz) => $clazz->uuid = (string) Uuid::uuid4());
    }

}
