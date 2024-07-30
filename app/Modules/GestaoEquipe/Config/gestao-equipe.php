<?php


use App\Modules\GestaoEquipe\Enums\PermissionEnum;

return [
    'menu' => [
        'key' => 'gestao_equipes_index',
        'icon'  => 'fas fa-users',
        'text' => 'Gestão de equipe',
        //'can'   => ,
        'active' => ['gestao-equipe/*'],
        'submenu' => [
            [
                'text' => 'Ver alocações',
                'route'  => 'gestao-equipe.alocacoes.index',
                'icon'  => 'fas fa-list',
                'active' => ['gestao-equipe/alocacoes/*'],
                'can'   => [PermissionEnum::VER_ALOCACAO->value, PermissionEnum::VER_MINHA_ALOCACAO->value],
            ],
        ]
    ]
];
