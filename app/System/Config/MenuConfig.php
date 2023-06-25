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
            $event->menu->add([
                'key' => 'home',
                'route' => 'home',
                'icon'  => 'fas  fa-home',
                'text' => 'Home',
                'can'   => 'ACESSAR_SISTEMA'
            ]);
            $event->menu->add([
                'text' => 'Sistema',
                'icon'  => 'fas  fa-cog',
                'submenu' => [
                    [
                        'key' => 'users_index',
                        'route' => 'users.index',
                        'icon'  => 'fas  fa-user',
                        'text' => 'Usuários',
                        'can'   => 'LISTAR_USUARIO',
                    ],
                    [
                        'key' => 'equipes_index',
                        'text' => 'Equipes',
                        'route'  => 'equipes.index',
                        'icon'  => 'fas fa-users',
                        'can'   => 'LISTAR_EQUIPE'
                    ]
                ]
            ]);

        });
    }
}
