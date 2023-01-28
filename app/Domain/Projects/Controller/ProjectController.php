<?php

namespace App\Domain\Projects\Controller;

use App\Application\Http\Controllers\Controller;
use App\Domain\Projects\Enum\CloneTypeEnum;
use App\Domain\Projects\Enum\StrategyEnum;
use App\Domain\Projects\Models\Project;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('project')]
#[Middleware(['api','auth:api'])]
class ProjectController extends Controller
{
    #[Get('/')]
    public function list(){

    }
}
