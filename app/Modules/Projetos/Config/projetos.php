<?php

use App\Modules\Projetos\Enums\PermissionEnum;

return [
    'menu' => [
        'text' => 'Projetos',
        'key' => 'projetos_index',
        'icon'  => 'fas fa-project-diagram',
        'submenu' =>[
            [
                'key' => 'aplicacao_index',
                'route' => 'aplicacoes.index',
                'icon'  => 'fas fa-cogs',
                'text' => 'Aplicações',
                'can'   => 'LISTAR_APLICACAO',
                'active' => ['projetos/aplicacoes/*'],
                'submenu' => [
                    [
                        'text' => 'Listar aplicações',
                        'route'  => 'aplicacoes.index',
                        'icon'  => 'fas fa-list',
                        'active' => ['projetos/aplicacoes/', 'projetos/aplicacoes/editar/*', 'projetos/aplicacoes/*/projetos/*'],
                        'can'   => 'LISTAR_APLICACAO',
                    ],
                    [
                        'text' => 'Inserir aplicação',
                        'route'  => 'aplicacoes.inserir',
                        'icon'  => 'fas fa-plus',
                        'active' => ['projetos/aplicacoes/inserir'],
                        'can'   => PermissionEnum::INSERIR_APLICACAO->value,
                    ]
                ]
            ],
            [
                'key' => 'testes_index',
                'route' => 'aplicacoes.planos-teste.index',
                'icon'  => 'fas fa-cogs',
                'text' => 'Testes',
                'can'   => ['LISTAR_CASO_TESTE', 'LISTAR_PLANO_TESTE'],
                'active' => ['projetos/casos-teste/*'],
                'submenu' => [
                    [
                        'text' => 'Casos de teste',
                        'icon'  => 'fas fa-cubes',
                        'key' => 'casos_teste_index',
                        'active' => ['projetos/casos-teste/*'],
                        'submenu' => [
                            [
                                'text' => 'Listar',
                                'route'  => 'aplicacoes.casos-teste.index',
                                'icon'  => 'fas fa-list',
                                'active' => ['projetos/casos-teste/', 'projetos/casos-teste/editar/*'],
                                'can'   => PermissionEnum::LISTAR_CASO_TESTE->value,
                            ],
                            [
                                'text' => 'Inserir',
                                'route'  => 'aplicacoes.casos-teste.inserir',
                                'icon'  => 'fas fa-plus',
                                'active' => ['projetos/casos-teste/inserir/*'],
                                'can'   => PermissionEnum::INSERIR_CASO_TESTE->value,
                            ],
                        ]
                    ],
                    [
                        'text' => 'Planos de teste',
                        'route'  => 'aplicacoes.planos-teste.index',
                        'icon'  => 'fas fa-file-alt',
                        'active' => ['projetos/planos-teste/*'],
                        'can'   => 'LISTAR_PLANO_TESTE',
                    ],


                ]
            ]
        ]
    ]
];
