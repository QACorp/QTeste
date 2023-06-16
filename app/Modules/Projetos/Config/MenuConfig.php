<?php

namespace App\Modules\Projetos\Config;

use App\System\Impl\MenuConfigAbstract;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class MenuConfig extends MenuConfigAbstract
{

    static function configureMenuModule()
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add('Projetos',[
                'key' => 'aplicacao_index',
                'route' => 'aplicacoes.index',
                'icon'  => 'fas fa-cogs',
                'text' => 'Aplicações',
                'can'   => 'LISTAR_APLICACAO',
                'active' => ['projetos/aplicacoes/*', 'projetos/casos-teste/*'],
                'submenu' => [
                    [
                        'text' => 'Listar aplicações',
                        'route'  => 'aplicacoes.index',
                        'icon'  => 'fas fa-list',
                        'active' => ['projetos/aplicacoes/*'],
                        'can'   => 'LISTAR_APLICACAO'
                    ],
                    [
                        'text' => 'Listar casos de teste',
                        'route'  => 'aplicacoes.casos-teste.index',
                        'icon'  => 'fas fa-cubes',
                        'active' => ['projetos/casos-teste/*'],
                        'can'   => 'LISTAR_CASO_TESTE'
                    ],
                    [
                        'text' => 'Listar planos de teste',
                        'route'  => 'aplicacoes.planos-teste.index',
                        'icon'  => 'fas fa-file-alt',
                        'active' => ['projetos/planos-teste/*'],
                        'can'   => 'LISTAR_PLANO_TESTE'
                    ]
                ]
            ]);
        });
    }
}
