<?php


use App\Modules\GestaoEquipe\Alocacao\Enums\PermissionEnum;

return [
    'menu' => [
        'key' => 'gestao_equipes_index',
        'icon'  => 'fas fa-users',
        'text' => 'Gestão de equipe',
        //'can'   => ,
        'active' => ['gestao-equipe/*'],
        'submenu' => [
            [
                'text' => 'Alocações',
                'route'  => 'gestao-equipe.alocacoes.index',
                'icon'  => 'fas fa-users-cog',
                'active' => ['gestao-equipe/alocacoes/*'],
                'can'   => [PermissionEnum::VER_ALOCACAO->value, PermissionEnum::VER_MINHA_ALOCACAO->value],
            ],
            [
                'text' => 'Checkpoints',
                'route'  => 'gestao-equipe.alocacoes.index',
                'icon'  => 'fas fa-users',
                'active' => ['gestao-equipe/alocacoes/*'],
                'can'   => [PermissionEnum::VER_ALOCACAO->value, PermissionEnum::VER_MINHA_ALOCACAO->value],
            ]
        ]
    ]
];
