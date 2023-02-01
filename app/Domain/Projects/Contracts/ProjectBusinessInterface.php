<?php

namespace App\Domain\Projects\Contracts;

use Spatie\LaravelData\DataCollection;

interface ProjectBusinessInterface
{
    public function listAllProjects():DataCollection;
}
