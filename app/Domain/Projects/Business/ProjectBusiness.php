<?php

namespace App\Domain\Projects\Business;

use App\Application\Abstracts\BusinessAbstract;
use App\Application\Abstracts\UuidBase;
use App\Domain\Projects\Contracts\ProjectBusinessInterface;
use App\Domain\Projects\Contracts\ProjectRepositoryInterface;
use App\Domain\Projects\DTO\ProjectDTO;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Exception\UuidExceptionInterface;
use Ramsey\Uuid\Uuid;
use Spatie\LaravelData\DataCollection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

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

    public function updateProject(ProjectDTO $projectDTO): ProjectDTO
    {
        if(!Uuid::isValid($projectDTO->uuid)){
            throw new UnprocessableEntityHttpException('Uuid inválido.');
        }
        try {
            return $this->projectRepository->updateProject($projectDTO);
        }catch (NotFoundHttpException $e) {
            throw $e;
        }
    }

    public function deleteProject(string $uuid): bool
    {

        if(!UuidBase::isValid($uuid)){
            throw new UnprocessableEntityHttpException('Uuid inválido.');
        }
        
        try {
            return $this->projectRepository->deleteProject($uuid);
        }catch (NotFoundHttpException $e) {
            throw $e;
        }


    }
}
