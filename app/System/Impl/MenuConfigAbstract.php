<?php

namespace App\System\Impl;

abstract class MenuConfigAbstract
{
    private static $menu = [];
    abstract static function configureMenuModule();

    public function addMenu(array $menu){
        self::$menu = array_merge(self::$menu, $menu);
    }
}
