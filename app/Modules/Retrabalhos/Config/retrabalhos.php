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
                'shift' => 'ml-3',
                'active' => ['retrabalhos/', 'retrabalhos/inserir','retrabalhos/show/*', 'retrabalhos/alterar/*'],
                'can'   => [PermissionEnum::LISTAR_RETRABALHO->value, PermissionEnum::VER_TODOS_RETRABALHOS->value]
            ],
            [
                'text' => 'Dashboard',
                'route'  => 'dashboard.index',
                'shift' => 'ml-3',
                'icon'  => 'fas fa-tachometer-alt',
                'active' => ['retrabalhos/dashboard/*'],
                'can'   => [PermissionEnum::VER_DASHBOARD->value]
            ],
            [
                'text' => 'Relatórios',
                'route'  => 'relatorios.index',
                'shift' => 'ml-3',
                'icon'  => 'fas fa-chart-area',
                'active' => ['retrabalhos/relatorios/*'],
                'can'   => [PermissionEnum::VER_RELATORIO_GESTOR->value, PermissionEnum::VER_RELATORIO_DESENVOLVEDOR->value, PermissionEnum::VER_RELATORIO_AUDITOR->value]
            ]
        ]
    ]
];
