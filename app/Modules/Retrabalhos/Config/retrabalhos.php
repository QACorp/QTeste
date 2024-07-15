<?php

use App\Modules\Retrabalhos\Enums\PermissionEnum;

return [
    'menu' => [
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
                'active' => ['retrabalhos/','retrabalhos/show/*', 'retrabalhos/alterar/*'],
                'can'   => [PermissionEnum::LISTAR_RETRABALHO->value, PermissionEnum::VER_TODOS_RETRABALHOS->value]
            ],
            [
                'text' => 'Inserir retrabalho',
                'route'  => 'retrabalhos.inserir',
                'icon'  => 'fas fa-plus',
                'active' => ['retrabalhos/inserir'],
                'can'   => [PermissionEnum::INSERIR_RETRABALHO->value]
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
    ]
];
