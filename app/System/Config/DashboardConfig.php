<?php

namespace App\System\Config;

use App\System\Component\Widget;

abstract class DashboardConfig
{
    private static $dashboardWidget = [];
    public static function addDashboardWidget(Widget $widget){
        static::$dashboardWidget[] = $widget;
    }
    public static function getDashboardWidget(){
        return static::$dashboardWidget;
    }
}
