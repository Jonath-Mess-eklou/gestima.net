<?php

namespace bin;

class Autoloaderd0f2fc4b2b97c18300fa420cf03c7028cd6a692234b0563c747665bed1d1b075
{

    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }
    private static function autoload($class)
    {
        if (strpos($class, __NAMESPACE__ . '\\') === 0) {
            $class = str_replace(__NAMESPACE__ . '\\', '', $class);
            $class = str_replace('\\', '/', $class);
            require _DIR_MAIN_ . '/' . $class . '.php';
        }
    }
}
