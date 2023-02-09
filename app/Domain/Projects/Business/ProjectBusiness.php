<?php

namespace App\Domain\Projects\Business;

use App\Application\Abstracts\BusinessAbstract;
use App\Domain\Projects\Contracts\ProjectBusinessInterface;
use App\Domain\Projects\Contracts\ProjectRepositoryInterface;
use App\Domain\Projects\DTO\ProjectDTO;
use Spatie\LaravelData\DataCollection;

class ProjectBusiness
    extends BusinessAbstract
    implements ProjectBusinessInterface
{
    public function __construct(
        private readonly ProjectRepositoryInterface $projectRepository
    )
    {
    }

    public function listAllProjects():DataCollection
    {
        return $this->projectRepository->getAllProject();
    }

    public function saveProject(ProjectDTO $projectDTO): ProjectDTO
    {
        return $this->projectRepository->saveProject($projectDTO);
    }
}
