<?php

namespace bin\controllers\controllers;

use bin\controllers\render\twig;
use bin\controllers\render\errors;

class Control_dashboard extends twig
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
    private $layouts;
    private $errors;

    function __construct()
    {
        $this->errors = new errors;
        $this->layouts = new \bin\epaphrodite\env\layouts;
        $this->sms = new \bin\epaphrodite\api\sms\send_sms;
        $this->msg = new \bin\epaphrodite\define\text_messages;
        $this->count = new \bin\database\requests\select\count;
        $this->session = new \bin\epaphrodite\auth\session_auth;
        $this->email = new \bin\epaphrodite\api\email\send_mail;
        $this->get_id = new \bin\database\requests\select\get_id;
    }

    public function epaphrodite($html)
    {

        if (file_exists(_DIR_VIEWS_ . _DIR_ADMIN_TEMP_ . $html . '.html')) {

            /**
             * ************************************************************************
             * Dashboard for super admin
             * 
             * @param string $html
             * @param array $array
             * @return mixed
             */
            if ($html === "dashboard/super_admin_ep") {


                $this->render(
                    _DIR_ADMIN_TEMP_ . $html,
                    [
                        'count' => $this->count,
                        'select' => $this->get_id,
                        'login' => $this->session->nomprenoms(),
                        'layouts' => $this->layouts->admin($this->session->type()),
                    ]
                );
            }

            /**
             * ************************************************************************
             * Dashboard for administrateur users
             * 
             * @param string $html
             * @param array $array
             * @return mixed
             */
            elseif ($html === "dashboard/admin_ep") {

                $this->render(
                    _DIR_ADMIN_TEMP_ . $html,
                    [
                        'count' => $this->count,
                        'select' => $this->get_id,
                        'login' => $this->session->nomprenoms(),
                        'layouts' => $this->layouts->admin($this->session->type()),
                    ]
                );
            }

            /**
             * ************************************************************************
             * Dashboard for simple users
             * 
             * @param string $html
             * @param array $array
             * @return mixed
             */
            elseif ($html === "dashboard/user_ep") {


                $this->render(
                    _DIR_ADMIN_TEMP_ . $html,
                    [
                        'count' => $this->count,
                        'select' => $this->get_id,
                        'login' => $this->session->nomprenoms(),
                        'layouts' => $this->layouts->admin($this->session->type()),
                    ]
                );
            } else {
                $this->errors->error_403();
            }
        } else {
            $this->errors->error_404();
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
