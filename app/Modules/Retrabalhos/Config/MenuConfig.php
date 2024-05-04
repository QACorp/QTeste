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
                        'text' => 'Listar retrabalhos',
                        'route'  => 'retrabalhos.index',
                        'icon'  => 'fas fa-list',
                        'active' => ['retrabalhos/', 'retrabalhos/inserir','retrabalhos/show/*', 'retrabalhos/alterar/*'],
                        'can'   => [PermissionEnum::LISTAR_RETRABALHO->value, PermissionEnum::VER_TODOS_RETRABALHOS->value]
                    ],
                    [
                        'text' => 'Dashboard',
                        'route'  => 'dashboard.index',
                        'icon'  => 'fas fa-tachometer-alt',
                        'active' => ['retrabalhos/dashboard/*'],
                        'can'   => [PermissionEnum::VER_DASHBOARD->value]
                    ],
                    [
                        'text' => 'Relatórios',
                        'route'  => 'relatorios.index',
                        'icon'  => 'fas fa-chart-area',
                        'active' => ['retrabalhos/relatorios/*'],
                        'can'   => [PermissionEnum::VER_RELATORIO_GESTOR->value, PermissionEnum::VER_RELATORIO_DESENVOLVEDOR->value, PermissionEnum::VER_RELATORIO_AUDITOR->value]
                    ]
                ]
            ]);
        });
    }
}
