<?php

namespace App\Modules\Projetos\Providers;

use App\System\Impl\ServiceProviderAbstract;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class ProjetosServiceProvider extends ServiceProviderAbstract
{
    protected string $module_path = 'Modules/Projetos';
    protected string $prefix = 'projetos';
    protected string $view_namespace = 'projetos';
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->addMenus();
        parent::boot();
    }
    public function addMenus(){
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            // Add some items to the menu...
            $event->menu->add('Projetos');
            $event->menu->add([
                'key' => 'project_index',
                'route' => 'projetos.index',
                'icon'  => 'fas  fa-users',
                'text' => 'Projetos',
                'url' => 'projetos',
            ]);
        });
    }

}
