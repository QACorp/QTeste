<?php

namespace App\Domain\Projects\Controller;

use App\Application\Http\Controllers\Controller;
use App\Domain\Projects\Contracts\ProjectBusinessInterface;
use App\Domain\Projects\DTO\ProjectDTO;
use App\Domain\Projects\Enum\CloneTypeEnum;
use App\Domain\Projects\Enum\StrategyEnum;
use App\Domain\Projects\Models\Project;
use App\Domain\Projects\Request\StoreProjectRequest;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('project')]
#[Middleware(['api','auth:api'])]
class ProjectController extends Controller
{
    public function __construct(
        private readonly ProjectBusinessInterface $projectBusiness
    )
    {
    }

    #[Get('/')]
    public function list(){
        return $this->projectBusiness->listAllProjects();
    }
    #[Post('/')]
    public function store(StoreProjectRequest $request){
        $projectDTO = ProjectDTO::from($request->all());
        $projectDTO = $this->projectBusiness->saveProject($projectDTO);
        return $projectDTO;
    }
}
