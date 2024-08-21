<?php


use App\Modules\GestaoEquipe\Alocacao\Enums\PermissionEnum;


return [
    'menu' => [
        'key' => 'checkpoint_index',
        'icon'  => 'fas fa-users',
        'text' => 'Checkpoint',
        'can'   => [PermissionEnum::VER_ALOCACAO->value, PermissionEnum::VER_MINHA_ALOCACAO->value],
        'active' => ['gestao-equipe/checkpoint/*'],
        'route'  => 'gestao-equipe.alocacoes.index',
//        'submenu' => [
//            [
//                'text' => 'Ver alocações',
//                'route'  => 'gestao-equipe.alocacoes.index',
//                'icon'  => 'fas fa-list',
//                'active' => ['gestao-equipe/alocacoes/*'],
//                'can'   => [PermissionEnum::VER_ALOCACAO->value, PermissionEnum::VER_MINHA_ALOCACAO->value],
//            ],
        //]
    ]
];
