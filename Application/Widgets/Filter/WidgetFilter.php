<?php

namespace Application\Widgets\Filter;

use Application\Controller;

class WidgetFilter
    extends Controller
{
    public static function display(){
        //$uri = $_SERVER['REQUEST_URI'];
        $uri = '/';
        include_once 'widget-filter-template.php';
    }
}