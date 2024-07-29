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

        ]
    ]
];
