<?php

namespace App\Modules\Retrabalhos\Config;

use App\Modules\Retrabalhos\Enums\PermissionEnum;
use App\System\Impl\MenuConfigAbstract;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class MenuConfig extends MenuConfigAbstract
{

    static function configureMenuModule()
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->addIn('projetos_index',[
                'key' => 'retrabalhos_index',
                'route' => 'retrabalhos.index',
                'icon'  => 'fas fa-cogs',
                'text' => 'Retrabalhos',
                //'can'   => ,
                'active' => ['retrabalhos/*'],
                'submenu' => [
                    [
                        'text' => 'Listar',
                        'route'  => 'retrabalhos.index',
                        'icon'  => 'fas fa-list',
                        'active' => ['retrabalhos/*'],
                        'can'   => [PermissionEnum::LISTAR_RETRABALHO->value, PermissionEnum::VER_TODOS_RETRABALHOS->value]
                    ]
                ]
            ]);
        });
    }
}
