<?php

namespace bin\controllers\controllers;

use bin\controllers\render\errors;
use bin\epaphrodite\heredia\SwtchersHeredia;

class Control extends SwtchersHeredia
{
    /**
     * *****************************************************************************************************************************
     * declare all variables
     *
     * @var \bin\epaphrodite\path\paths $paths
     * @var \bin\epaphrodite\auth\session_auth $path_session
     * @var \bin\epaphrodite\define\text_messages $msg
     * @var \bin\epaphrodite\email\send_mail $email
     * @var \bin\epaphrodite\api\sms\send_sms $sms
     * @var \bin\controllers\render\errors $errors
     * @var \bin\database\requests\select\auth $auth
     * @var \bin\epaphrodite\env\layouts $layouts
     */

    private $auth;

    private $insert;
    private $email;
    private $sms;
    private $env;
    private $msg;
    private $errors;
    private $session;
    private $rooter;

    /**
     * *****************************************************************************************************************************
     * Get class
     */
    function __construct()
    {

        $this->errors = new errors;
        $this->env = new \bin\epaphrodite\env\env;
        $this->sms = new \bin\epaphrodite\api\sms\send_sms;
        $this->auth = new \bin\database\requests\select\auth;
        $this->msg = new \bin\epaphrodite\define\SetTextMessages;
        $this->session = new \bin\epaphrodite\auth\session_auth;
        $this->email = new \bin\epaphrodite\api\email\send_mail;
        $this->insert = new \bin\database\requests\insert\insert;
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
    
        SELF::directory( $html ) === false ? $this->errors->error_404() : NULL;
        
            /**
             * *****************************************************************************************************************************
             * main index
             * 
             * @param string $html
             * @param array $array
             * @return mixed
             */
           
             if(SELF::SwitcherPages( 'index' , $html )===true){

                if(isset($_POST['ajouter'])){

                    $result = $this->insert->addImages( $_POST['imge'] , $_POST['lien'] );
                    if ($result === true) {
                        $ans = $this->msg->answers('testjo');
                        $class = "success";
                    }
                    
                }

                SELF::rooter()->target( _DIR_MAIN_TEMP_ . $html )->content([NULL])->get();  
             }

            /**
             * *****************************************************************************************************************************
             * Authentification page ( login )
             * 
             * @param string $html
             * @param array $array
             * @return mixed
             */
            if (SELF::SwitcherPages('login' , $html )===true) {

                $class = null;
                $ans = '';

                if (isset($_POST['submit'])) {

                    $result = $this->auth->UsersAuthManagers($_POST['login'], $_POST['password']);
                    if ($result === false) {
                        $ans = $this->msg->answers('login-wrong');
                        $class = "error";
                    }
                }

                SELF::rooter()->target(_DIR_MAIN_TEMP_. $html)->content(['class' => $class,'reponse' => $ans])->get(); 
            } 
    }
}


class main extends Control
{
    public function send($html)
    {

        $this->epaphrodite($html);
    }
}
