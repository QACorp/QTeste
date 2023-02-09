<?php

namespace App\Domain\Projects\Contracts;





use App\Domain\Projects\DTO\ProjectDTO;
use Illuminate\Support\Enumerable;
use Spatie\LaravelData\DataCollection;

interface ProjectRepositoryInterface
{
    public function getAllProject():DataCollection;
    public function saveProject(ProjectDTO $projectDTO):ProjectDTO;
}
