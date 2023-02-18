<?php

namespace App\Domain\Projects\Repository;

use App\Application\Abstracts\UuidBase;
use App\Domain\Projects\Contracts\ProjectRepositoryInterface;
use App\Domain\Projects\DTO\ProjectDTO;
use App\Domain\Projects\Models\Project;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Ramsey\Uuid\Uuid;
use Spatie\LaravelData\DataCollection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function PHPUnit\Framework\throwException;

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
    private function findProject(string $uuid):Project
    {
        $project = Project::find($uuid);
        if(!$project){
            throw new NotFoundHttpException('Projeto não encontrado!');
        }
        return $project;
    }
    public function updateProject(ProjectDTO $projectDTO): ProjectDTO
    {
        $project = $this->findProject($projectDTO->uuid);
        $project->fill($projectDTO->toArray());
        $project->update();

        return ProjectDTO::from($project);
    }

    public function deleteProject(string $projectId): bool
    {
        $project = $this->findProject($projectId);
        return $project->delete();
    }
}
