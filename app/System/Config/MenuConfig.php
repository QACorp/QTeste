<?php

namespace App\System\Config;

use App\System\Impl\MenuConfigAbstract;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class MenuConfig extends MenuConfigAbstract
{

    static function configureMenuModule()
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            // Add some items to the menu...
            $event->menu->add('Usuários',[
                'key' => 'users_index',
                'route' => 'users.index',
                'icon'  => 'fas  fa-users',
                'text' => 'Usuários',
                'can'   => 'LISTAR_USUARIO'
            ]);

        });
    }
}
