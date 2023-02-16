<?php

namespace App\Domain\Projects\Contracts;

use App\Domain\Projects\DTO\ProjectDTO;
use Spatie\LaravelData\DataCollection;

interface ProjectBusinessInterface
{
    public function listAllProjects():DataCollection;
    public function saveProject(ProjectDTO $projectDTO):ProjectDTO;
    public function updateProject(ProjectDTO $projectDTO):ProjectDTO;
}
