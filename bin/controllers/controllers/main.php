<?php

namespace bin\controllers\controllers;

use bin\controllers\render\twig;
use bin\controllers\render\errors;

class Control extends twig
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

    private $ans;
    private $result;
    private $auth;
    private $layouts;
    private $paths;
    private $email;
    private $sms;
    private $env;
    private $msg;
    private $errors;
    private $session;

    /**
     * *****************************************************************************************************************************
     * Get class
     */
    function __construct()
    {

        $this->errors = new errors;
        $this->env = new \bin\epaphrodite\env\env;
        $this->paths = new \bin\epaphrodite\path\paths;
        $this->layouts = new \bin\epaphrodite\env\layouts;
        $this->sms = new \bin\epaphrodite\api\sms\send_sms;
        $this->auth = new \bin\database\requests\select\auth;
        $this->msg = new \bin\epaphrodite\define\text_messages;
        $this->session = new \bin\epaphrodite\auth\session_auth;
        $this->email = new \bin\epaphrodite\api\email\send_mail;
    }


    protected function epaphrodite($html)
    {


        if (file_exists(_DIR_VIEWS_ . _DIR_MAIN_TEMP_ . $html . '.html')) {
            /**
             * *****************************************************************************************************************************
             * main index
             * 
             * @param string $html
             * @param array $array
             * @return mixed
             */
            if ($html === "index_ep") {
                $this->render(
                    _DIR_MAIN_TEMP_ . $html,
                    [
                        'path' => $this->paths,
                        'layouts' => $this->layouts->main(),
                    ]
                );
            }

            /**
             * *****************************************************************************************************************************
             * Authentification page ( login )
             * 
             * @param string $html
             * @param array $array
             * @return mixed
             */
            elseif ($html === "login_ep") {

                $this->ans = '';
                $class = null;

                if (isset($_POST['submit'])) {

                    $this->result = $this->auth->acces_manager($_POST['login'], $_POST['password']);
                    if ($this->result === false) {
                        $this->ans = $this->msg->answers('login-wrong');
                        $class = "error";
                    }
                }

                $this->render(
                    _DIR_MAIN_TEMP_ . $html,
                    [
                        'class' => $class,
                        'path' => $this->paths,
                        'reponse' => $this->ans,
                        'form' => $this->layouts->forms(),
                        'layouts' => $this->layouts->main(),
                    ]
                );
            } else {
                $this->errors->error_404();
            }
        } else {
            $this->errors->error_404();
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
