<?php

namespace App\Domain\Projects\DTO;

use App\Application\Abstracts\DTOAbstract;

class ProjectDTO extends DTOAbstract
{
    public string|null $uuid;
    public string|null $branchs;
    public string|null $strategy;
    public string|null $url_repository;
    public string|null $url_git_clone;
    public string|null $clone_type;
    public string|null $custom_script;

}
