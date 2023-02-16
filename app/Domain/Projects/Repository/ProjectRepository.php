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


    public function saveProject(ProjectDTO $projectDTO): ProjectDTO
    {
        $project = new Project($projectDTO->toArray());
        $project->save();
        return ProjectDTO::from($project);
    }

    public function updateProject(ProjectDTO $projectDTO): ProjectDTO
    {
        $project = Project::find($projectDTO->uuid);
        $project->fill($projectDTO->toArray());
        $project->update();

        return ProjectDTO::from($project);
    }
}
