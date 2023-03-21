<?php

namespace bin\controllers\switchers;

use bin\epaphrodite\constant\EpaphClass;

class ControllersSwitchers extends EpaphClass {

    public function SwitchControllers( $class , $pages)
    {
        return $class->send($pages);
    }

    public static function GetController( $controller , $provider , ?bool $switch = false){

        SELF::crsf()->tocsrf() === false ? SELF::errors()->error_403() : NULL;

        if($switch === false){
            return $controller === $provider[0] ? true : false;
        }else{
            return $controller === $provider[0] && SELF::auth()->id()!==NULL  ? true : false;
        }
    }   
}