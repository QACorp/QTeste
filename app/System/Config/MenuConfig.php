<?php

namespace App\System\Config;

use App\System\Enums\PermissionEnum;
use App\System\Impl\MenuConfigAbstract;
use App\System\Impl\ServiceProviderAbstract;
use App\System\Providers\AppServiceProvider;
use App\System\Utils\EquipeUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class MenuConfig extends MenuConfigAbstract
{

    public static function configureMenuModule()
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            // Add some items to the menu...
            $request = App::make(Request::class);
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
                'text' => 'Alterar dados da empresa',
                'route' => 'users.alterar-empresa',
                'icon' => 'fas fa-building',
                'classes' => 'nav-item',
                'topnav_user' => true
            ]);
            $event->menu->add([
                'text' => 'Configurações',
                'route' => 'configuracao.index',
                'icon' => 'fas fa-cog',
                'classes' => 'nav-item',
                'topnav_user' => true,
                'can'   => 'ACESSAR_CONFIGURACAO_EMPRESA'
            ]);

            $event->menu->add([
                'text' => 'Sistema',
                'icon'  => 'fas  fa-cog',
                'can'   => ['LISTAR_USUARIO','LISTAR_EQUIPE'],
                'submenu' => [
                    [
                        'key' => 'users_index',
                        'route' => 'users.index',
                        'classes' => 'ml-4',
                        'icon'  => 'fas  fa-user',
                        'text' => 'Usuários',
                        'can'   => 'LISTAR_USUARIO',
                        'active' => ['usuarios/*']
                    ],
                    [
                        'key' => 'equipes_index',
                        'classes' => 'ml-4',
                        'text' => 'Equipes',
                        'route'  => 'equipes.index',
                        'icon'  => 'fas fa-users',
                        'can'   => 'LISTAR_EQUIPE',
                        'active' => ['equipes/*']
                    ]
                ]
            ]);

        });
        self::configureMenuServicesProvider();
    }
    private static function configureMenuServicesProvider(){
        $servicesProvider = Collection::make(App::getProviders(ServiceProviderAbstract::class));
        $servicesProvider->each(function ($item, $key) {
            Event::listen(BuildingMenu::class, function (BuildingMenu $event)  use ($item){
                $event->menu->add(config($item->getPrefix() . '.menu',[]));
            });


        });
    }
}
