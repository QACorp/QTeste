<?php

namespace App\Domain\Projects\Provider;

use App\Application\Abstracts\ServiceProviderAbstract;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ProjectsServiceProvider extends ServiceProviderAbstract implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */


}
