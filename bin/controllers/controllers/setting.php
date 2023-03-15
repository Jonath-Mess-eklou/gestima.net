<?php

namespace bin\controllers\controllers;

use bin\controllers\render\twig;
use bin\controllers\render\errors;

class parametre_app extends twig
{

    /**
     * declare variables
     *
     * @var \bin\epaphrodite\path\paths $path
     * @var \bin\database\users_right\datas_array $datas
     * @var \bin\epaphrodite\auth\session_auth $session
     * @var \bin\epaphrodite\crf_token\token_csrf $csrf
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
        $this->path = new \bin\epaphrodite\path\paths;
        $this->layouts = new \bin\epaphrodite\env\layouts;
        $this->msg = new \bin\epaphrodite\define\text_messages;
        $this->count = new \bin\database\requests\select\count;
        $this->session = new \bin\epaphrodite\auth\session_auth;
        $this->update = new \bin\database\requests\update\update;
        $this->insert = new \bin\database\requests\insert\insert;
        $this->delete = new \bin\database\requests\delete\delete;
        $this->acces_path = new \bin\database\requests\select\auth;
        $this->get_id = new \bin\database\requests\select\get_id;
    }

    public function epaphrodite($html)
    {

        if (file_exists(_DIR_VIEWS_ . _DIR_ADMIN_TEMP_ . $html . '.html')) {
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
            if ($html === "setting/ajouter_droits_acces_utilisateur_ep" && $this->session->type() === 1) {

                $reponses = '';
                $alert = '';
                $idtype = 0;

                if (isset($_GET['_see'])) {
                    $idtype = $_GET['_see'];
                }

                if (isset($_POST['submit']) && $idtype !== 0) {

                    $this->result = $this->insert->users_rights($idtype, $_POST['__droits__'], $_POST['__actions__']);

                    if ($this->result === true) {
                        $alert = 'alert-success';
                        $reponses = $this->msg->answers('succes');
                    }
                    if ($this->result === false) {
                        $alert = 'alert-danger';
                        $reponses = $this->msg->answers('rightexist');
                    }
                }

                $this->render(
                    _DIR_ADMIN_TEMP_ . $html,
                    [
                        'alert' => $alert,
                        'type' => $idtype,
                        'env' => $this->env,
                        'path' => $this->path,
                        'reponse' => $reponses,
                        'datas' => $this->datas,
                        'messages' => $this->msg,
                        'form' => $this->layouts->forms(),
                        'message' => $this->layouts->msg(),
                        'login' => $this->session->nomprenoms(),
                        'breadcrumb' => $this->layouts->breadcrumbs(),
                        'layouts' => $this->layouts->admin($this->session->type()),
                    ]
                );
            }

            /**
             * Liste des droits d'utilisateurs par type d'utilisateur
             * 
             * @param string $html
             * @param array $array
             * @return mixed
             */
            elseif ($html === "setting/liste_gest_droits_users_ep" && $this->session->type() === 1) {

                $reponses = '';
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
                        $reponses = $this->msg->answers('succes');
                    }
                    if ($this->result === false) {
                        $alert = 'alert-danger';
                        $reponses = $this->msg->answers('error');
                    }
                }

                if (isset($_POST['__refuser__'])) {

                    $this->result = $this->update->users_rights($_POST['__refuser__'], 0);

                    if ($this->result === true) {
                        $alert = 'alert-success';
                        $reponses = $this->msg->answers('succes');
                    }
                    if ($this->result === false) {
                        $alert = 'alert-danger';
                        $reponses = $this->msg->answers('error');
                    }
                }

                if (isset($_POST['__deleted__'])) {

                    $this->result = $this->delete->users_rights($_POST['__deleted__']);

                    if ($this->result === true) {
                        $alert = 'alert-success';
                        $reponses = $this->msg->answers('succes');
                    }
                    if ($this->result === false) {
                        $alert = 'alert-danger';
                        $reponses = $this->msg->answers('error');
                    }
                }

                $this->render(
                    _DIR_ADMIN_TEMP_ . $html,
                    [
                        'path' => $this->path,
                        'env' => $this->env,
                        'messages' => $this->msg,
                        'reponse' => $reponses,
                        'alert' => $alert,
                        'datas' => $this->datas,
                        'menus' => $this->get_id,
                        'select' => $this->get_id->users_rights($idtype),
                        'form' => $this->layouts->forms(),
                        'message' => $this->layouts->msg(),
                        'login' => $this->session->nomprenoms(),
                        'breadcrumb' => $this->layouts->breadcrumbs(),
                        'layouts' => $this->layouts->admin($this->session->type()),
                    ]
                );
            }

            /**
             * Liste des types d'utilisateur avec attribution de droits
             * 
             * @param string $html
             * @param array $array
             * @return mixed
             */
            elseif ($html === "setting/gest_droits_acces_users_ep" && $this->session->type() === 1) {

                $reponses = '';
                $alert = '';

                if (isset($_POST['__deleted__'])) {

                    if ($this->get_id->autorisations('adduriht') === true || $this->session->type() === 1) {

                        $this->result = $this->delete->empty_users_right($_POST['__deleted__']);

                        if ($this->result === true) {
                            $alert = 'alert-success';
                            $reponses = $this->msg->answers('succes');
                        }
                        if ($this->result === false) {
                            $alert = 'alert-danger';
                            $reponses = $this->msg->answers('error');
                        }
                    } else {
                        $alert = 'alert-danger';
                        $reponses = $this->msg->answers('denie_action');
                    }
                }

                $this->render(
                    _DIR_ADMIN_TEMP_ . $html,
                    [
                        'path' => $this->path,
                        'env' => $this->env,
                        'reponse' => $reponses,
                        'alert' => $alert,
                        'auth' => $this->session,
                        'datas' => $this->datas,
                        'messages' => $this->msg,
                        'select' => $this->datas->user(),
                        'form' => $this->layouts->forms(),
                        'message' => $this->layouts->msg(),
                        'login' => $this->session->nomprenoms(),
                        'breadcrumb' => $this->layouts->breadcrumbs(),
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

class setting extends parametre_app
{
    public function send($html)
    {

        $this->epaphrodite($html);
    }
}
