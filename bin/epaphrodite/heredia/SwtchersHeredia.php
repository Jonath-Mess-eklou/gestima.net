<?php

namespace bin\epaphrodite\heredia;

use bin\controllers\render\errors;

class SwtchersHeredia extends errors{
    
    /**
     * @param string|null $target
     * @param string|null $url
     */
    public static function SwitcherPages( ?string $target = null , ?string $url = null ){

        return $target . _MAIN_EXTENSION_ === $url ? true : false;
    }


    /**
     * @param string|null $html
     * @param bool|false $switch
     */
    public static function directory( ?string $html = null , ?bool $switch = false ){

        return $switch === false ? file_exists( _DIR_VIEWS_ . _DIR_MAIN_TEMP_ . $html . '.html' ) : file_exists( _DIR_VIEWS_ . _DIR_ADMIN_TEMP_ . $html . '.html' );
    }


}

