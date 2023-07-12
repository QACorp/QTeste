<?php

namespace App\System\Config;

use App\System\Impl\MenuConfigAbstract;
use App\System\Utils\EquipeUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class MenuConfig extends MenuConfigAbstract
{

    static function configureMenuModule()
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            // Add some items to the menu...
            $request = App::make(Request::class);
            //Cookie::queue(config('app.cookie_equipe_nome'), 8, (60*60*60));
            Auth::user()->equipes()->each(function ($item, $key) use(&$event, $request) {
                $event->menu->add(
                    [
                        'key' => $item->id.'-'.$item->nome,
                        //'topnav_user' => true,
                        'topnav' => true,
                        'url' => route('users.atualizar-equipe',$item->id),
                        'icon'  => EquipeUtils::equipeUsuarioLogado() == $item->id ? 'fas fa-check': 'fas fa-users',
                        'text' => $item->nome,
                        'can'   => 'ACESSAR_SISTEMA'
                    ]
                );
            });



            $event->menu->add(
                [
                    'type'         => 'fullscreen-widget',
                    'topnav_right' => true,
                ],
            );

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
                'can'   => ['LISTAR_USUARIO','LISTAR_EQUIPE'],
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
                        'can'   => 'LISTAR_EQUIPE',
                        'active' => ['equipes/*']
                    ]
                ]
            ]);

        });
    }
}
