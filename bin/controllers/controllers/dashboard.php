<?php

namespace bin\controllers\controllers;

use bin\controllers\render\errors;
use bin\epaphrodite\heredia\SwtchersHeredia;

class Control_dashboard extends SwtchersHeredia
{

    /**
     * declare variables
     *
     * @var \bin\epaphrodite\path\paths $paths
     * @var \bin\epaphrodite\crf_token\token_csrf $csrf
     * @var \bin\epaphrodite\auth\session_auth $auth
     * @var \bin\epaphrodite\define\text_messages $msg
     * @var \bin\epaphrodite\api\sms\send_sms $sms
     * @var \bin\epaphrodite\email\send_mail $mail
     * @var \bin\epaphrodite\env\layouts $layouts
     * @var \bin\epaphrodite\env\env $env
     * @var \bin\controllers\render\errors $errors
     */
    private $sms;
    private $msg;
    private $env;
    private $auth;
    private $count;
    private $email;
    private $paths;
    private $get_id;
    private $session;
    private $errors;

    function __construct()
    {
        $this->errors = new errors;
        $this->sms = new \bin\epaphrodite\api\sms\send_sms;
        $this->msg = new \bin\epaphrodite\define\SetTextMessages;
        $this->count = new \bin\database\requests\select\count;
        $this->session = new \bin\epaphrodite\auth\session_auth;
        $this->email = new \bin\epaphrodite\api\email\send_mail;
        $this->get_id = new \bin\database\requests\select\get_id;
    }

    /**
     * **********************************************************************************************
        * Rooter constructor
        *
        * @return \bin\controllers\render\rooter
    */
    private static function rooter(): \bin\controllers\render\rooter
    {
        return new \bin\controllers\render\rooter;
    }

    protected function epaphrodite($html)
    {

        SELF::directory( $html , true) === false ? $this->errors->error_404() : NULL;
            
            /**
             * ************************************************************************
             * Dashboard for super admin
             * 
             * @param string $html
             * @param array $array
             * @return mixed
             */
            if ( SELF::SwitcherPages( 'dashboard/super_admin' , $html ) === true ) {

                SELF::rooter()->target( _DIR_ADMIN_TEMP_ . $html )->content(['count' => $this->count,'select' => $this->get_id,],true)->get(); 
            }

            /**
             * ************************************************************************
             * Dashboard for administrateur users
             * 
             * @param string $html
             * @param array $array
             * @return mixed
             */
            if ( SELF::SwitcherPages( 'dashboard/admin' , $html ) === true ) {

                SELF::rooter()->target( _DIR_ADMIN_TEMP_ . $html )->content(['count' => $this->count,'select' => $this->get_id],true)->get(); 
            }

            /**
             * ************************************************************************
             * Dashboard for simple users
             * 
             * @param string $html
             * @param array $array
             * @return mixed
             */
            if (SELF::SwitcherPages( 'dashboard/user' , $html ) === true) {

                SELF::rooter()->target( _DIR_ADMIN_TEMP_ . $html )->content(['count' => $this->count,'select' => $this->get_id,],true)->get(); 
            } 
    }
}

class dashboard extends Control_dashboard
{
    public function send($html)
    {
        $this->epaphrodite($html);
    }
}
