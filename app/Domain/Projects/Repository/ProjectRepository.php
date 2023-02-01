<?php

namespace App\Domain\Projects\Repository;

use App\Domain\Projects\Contracts\ProjectRepositoryInterface;
use App\Domain\Projects\DTO\ProjectDTO;
use App\Domain\Projects\Models\Project;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Spatie\LaravelData\DataCollection;

class ProjectRepository
    implements ProjectRepositoryInterface
{

    public function getAllProject(): DataCollection
    {
        //dd(ProjectDTO::collection(Project::all()));
        return ProjectDTO::collection(Project::all());
    }
}
