<?php

namespace App\Domain\Projects\Provider;

use App\Application\Abstracts\ServiceProviderAbstract;
use App\Domain\Projects\Business\ProjectBusiness;
use App\Domain\Projects\Contracts\ProjectBusinessInterface;
use App\Domain\Projects\Contracts\ProjectRepositoryInterface;
use App\Domain\Projects\Repository\ProjectRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ProjectsServiceProvider
    extends ServiceProviderAbstract
    implements DeferrableProvider
{
    public array $bindings = [
        ProjectBusinessInterface::class => ProjectBusiness::class,
        ProjectRepositoryInterface::class => ProjectRepository::class
    ];



}
