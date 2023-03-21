<?php

namespace bin\controllers\switchers;

use bin\controllers\switchers\ControllersSwitchers;

class GetControllers extends ControllersSwitchers
{
    private $main;
    private $users;
    private $setting;
    private $dashboard;

    /**
     * Get class
     * @return void
    */
    public function __construct()
    {
        $this->main = new \bin\controllers\controllers\main;
        $this->setting = new \bin\controllers\controllers\setting;
        $this->users = new \bin\controllers\controllers\utilisateur;
        $this->dashboard = new \bin\controllers\controllers\dashboard;
    }

    /**
      * Return true controller
      *
      * @param null|array $provider
      * @param null|string $paths
      * @return void
    */
    public function SwitchMainControllers( ?array $provider = [] , ?string $paths = NULL ):void
    {

        /**
         * @param mixed $controller
         * @param mixed $provider
         * @param null|bool $switch
         * @return bool
        */
        switch ( $provider ) 
        {
            case SELF::GetController( "dashboard" , $provider , true ) === true:

                $this->SwitchControllers( $this->dashboard , $paths );
                break;

            case SELF::GetController( "users" , $provider , true ) === true:

                $this->SwitchControllers( $this->users , $paths );
                break;

            case SELF::GetController( "setting" , $provider , true ) === true:
                
                $this->SwitchControllers( $this->setting , $paths );
                break;

            default:
            $this->SwitchControllers( $this->main , $paths );
        }
    }
}