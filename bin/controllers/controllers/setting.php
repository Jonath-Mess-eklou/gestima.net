<?php

namespace bin\controllers\controllers;

use bin\controllers\render\errors;
use bin\epaphrodite\heredia\SwtchersHeredia;

class parametre_app extends SwtchersHeredia
{

    /**
     * declare variables
     *
     * @var \bin\epaphrodite\path\paths $path
     * @var \bin\database\users_right\datas_array $datas
     * @var \bin\epaphrodite\auth\session_auth $session
     * @var \bin\epaphrodite\env\layouts $layouts
     * @var \bin\epaphrodite\define\text_messages $msg
     * @var \bin\database\requests\select\sql_infosgeneral $infos 
     * @var \bin\database\requests\update\update_sql $update
     * @var \bin\epaphrodite\email\send_mail $mail
     * @var \bin\controllers\render\errors $errors
     * @var \bin\database\requests\insert\insert_sql $insert
     * 
     */
    private $env;
    private $result;
    private $path;
    private $layouts;
    private $session;
    private $msg;
    private $datas;
    private $infos;
    private $ans;
    private $update;
    private $errors;
    private $get_id;
    private $insert;
    private $delete;
    private $count;
    private $acces_path;
    private $param;

    function __construct()
    {

        $this->errors = new errors;
        $this->env = new \bin\epaphrodite\env\env;
        $this->datas = new \bin\database\datas\datas;
        $this->layouts = new \bin\epaphrodite\env\layouts;
        $this->msg = new \bin\epaphrodite\define\SetTextMessages;
        $this->count = new \bin\database\requests\select\count;
        $this->session = new \bin\epaphrodite\auth\session_auth;
        $this->update = new \bin\database\requests\update\update;
        $this->insert = new \bin\database\requests\insert\insert;
        $this->delete = new \bin\database\requests\delete\delete;
        $this->acces_path = new \bin\database\requests\select\auth;
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
             * @param string $alert
             */
            $alert = '';

            /**
             * Ajouter des droits d'acces aux utilisateurs de la plateforme
             * 
             * @param string $html
             * @param array $array
             * @return mixed
             */
            if ( SELF::SwitcherPages( 'setting/ajouter_droits_acces_utilisateur' , $html ) === true ) {

                $ans = '';
                $alert = '';
                $idtype = 0;

                if (isset($_GET['_see'])) {
                    $idtype = $_GET['_see'];
                }

                if (isset($_POST['submit']) && $idtype !== 0) {

                    $this->result = $this->insert->users_rights($idtype, $_POST['__droits__'], $_POST['__actions__']);

                    if ($this->result === true) {
                        $alert = 'alert-success';
                        $ans = $this->msg->answers('succes');
                    }
                    if ($this->result === false) {
                        $alert = 'alert-danger';
                        $ans = $this->msg->answers('rightexist');
                    }
                }

                SELF::rooter()->target( _DIR_ADMIN_TEMP_ . $html )->content( [ 'type' => $idtype , 'reponse' => $ans, 'alert' => $alert, 'env' => $this->env, 'data' => $this->datas, ],true)->get();
            }

            /**
             * Liste des droits d'utilisateurs par type d'utilisateur
             * 
             * @param string $html
             * @param array $array
             * @return mixed
             */
            if ( SELF::SwitcherPages( 'setting/liste_gest_droits_users' , $html ) === true ) {

                $ans = '';
                $alert = '';
                $select = [];
                $idtype = 0;

                if (isset($_GET['_see'])) {
                    $idtype = $_GET['_see'];
                }

                if (isset($_POST['__autorisation__'])) {

                    $this->result = $this->update->users_rights($_POST['__autorisation__'], 1, $idtype);

                    if ($this->result === true) {
                        $alert = 'alert-success';
                        $ans = $this->msg->answers('succes');
                    }
                    if ($this->result === false) {
                        $alert = 'alert-danger';
                        $ans = $this->msg->answers('error');
                    }
                }

                if (isset($_POST['__refuser__'])) {

                    $this->result = $this->update->users_rights($_POST['__refuser__'], 0);

                    if ($this->result === true) {
                        $alert = 'alert-success';
                        $ans = $this->msg->answers('succes');
                    }
                    if ($this->result === false) {
                        $alert = 'alert-danger';
                        $ans = $this->msg->answers('error');
                    }
                }

                if (isset($_POST['__deleted__'])) {

                    $this->result = $this->delete->users_rights($_POST['__deleted__']);

                    if ($this->result === true) {
                        $alert = 'alert-success';
                        $ans = $this->msg->answers('succes');
                    }
                    if ($this->result === false) {
                        $alert = 'alert-danger';
                        $ans = $this->msg->answers('error');
                    }
                }

                SELF::rooter()->target( _DIR_ADMIN_TEMP_ . $html )->content( [ 'select' => $this->get_id->users_rights($idtype) , 'reponse' => $ans , 'alert' => $alert , 'env' => $this->env , 'data' => $this->datas ],true)->get();
            }

            /**
             * Liste des types d'utilisateur avec attribution de droits
             * 
             * @param string $html
             * @param array $array
             * @return mixed
             */
            if ( SELF::SwitcherPages( 'setting/gest_droits_acces_users' , $html ) === true ) {

                $ans = '';
                $alert = '';

                if (isset($_POST['__deleted__'])) {

                    if ($this->get_id->autorisations('adduriht') === true || $this->session->type() === 1) {

                        $this->result = $this->delete->empty_users_right($_POST['__deleted__']);

                        if ($this->result === true) {
                            $alert = 'alert-success';
                            $ans = $this->msg->answers('succes');
                        }
                        if ($this->result === false) {
                            $alert = 'alert-danger';
                            $ans = $this->msg->answers('error');
                        }
                    } else {
                        $alert = 'alert-danger';
                        $ans = $this->msg->answers('denie_action');
                    }
                }

                SELF::rooter()->target( _DIR_ADMIN_TEMP_ . $html )->content( [ 'select' => $this->datas->user() , 'auth' => $this->session , 'reponse' => $ans , 'alert' => $alert , 'env' => $this->env , 'datas' => $this->datas ],true)->get();
            } 
    }
}

class setting extends parametre_app
{
    public function send($html)
    {

        $this->epaphrodite($html);
    }
}
