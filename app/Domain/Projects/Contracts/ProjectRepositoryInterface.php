<?php

namespace App\Domain\Projects\Contracts;





use Illuminate\Support\Enumerable;
use Spatie\LaravelData\DataCollection;

interface ProjectRepositoryInterface
{
    public function getAllProject():DataCollection;
}
