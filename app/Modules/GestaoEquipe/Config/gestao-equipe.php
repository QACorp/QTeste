<?php


use App\Modules\GestaoEquipe\Submodules\Checkpoint\Enums\PermissionEnum as PermissionEnumCheckpoint;
use App\Modules\GestaoEquipe\Submodules\Alocacao\Enums\PermissionEnum as PermissionEnumAlocacao;
use App\Modules\GestaoEquipe\Submodules\Observacao\Enums\PermissionEnum as PermissionEnumObservacao;

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
                'active' => ['alocacao/*'],
                'can'   => [PermissionEnumAlocacao::VER_ALOCACAO->value, PermissionEnumAlocacao::VER_MINHA_ALOCACAO->value],
            ],
            [
                'text' => 'Equipe',
                'route'  => 'gestao-equipe.checkpoint.index',
                'icon'  => 'fas fa-users',
                'active' => ['checkpoint/*', 'gestao-equipe/*'],
                'can'   => [PermissionEnumCheckpoint::VER_CHECKPOINT->value, PermissionEnumObservacao::LISTAR_OBSERVACAO->value],
            ]
        ]
    ]
];
