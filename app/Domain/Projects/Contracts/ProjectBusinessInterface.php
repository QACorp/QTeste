<?php

namespace App\Domain\Projects\Contracts;

use App\Application\Abstracts\UuidBase;
use App\Domain\Projects\DTO\ProjectDTO;
use Ramsey\Uuid\Uuid;
use Spatie\LaravelData\DataCollection;

interface ProjectBusinessInterface
{
    public function listAllProjects():DataCollection;
    public function saveProject(ProjectDTO $projectDTO):ProjectDTO;
    public function updateProject(ProjectDTO $projectDTO):ProjectDTO;
    public function deleteProject(string $uuid):bool;
}
