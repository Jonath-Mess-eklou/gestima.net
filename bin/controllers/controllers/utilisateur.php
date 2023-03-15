<?php

namespace bin\controllers\controllers;

use bin\controllers\render\twig;
use bin\controllers\render\errors;

class utilisateur_app extends twig
{

    /**
     * declare variables
     *
     * @var \bin\epaphrodite\path\paths $url_path
     * @var \bin\database\users_right\datas_array $datas
     * @var \bin\epaphrodite\auth\session_auth $path_session
     * @var \bin\epaphrodite\crf_token\token_csrf $csrf
     * @var \bin\epaphrodite\env\layouts $layouts
     * @var \bin\epaphrodite\define\text_messages $msg
     * @var \bin\database\requests\select\sql_infosgeneral $infos 
     * @var \bin\database\requests\update\update_sql $update
     * @var \bin\epaphrodite\email\send_mail $mail
     * @var \bin\controllers\render\errors $errors
     * @var \bin\database\requests\insert\insert $insert_datas
     * 
     */
    private $path;
    private $env;
    private $csrf;
    private $layouts;
    private $session;
    private $msg;
    private $datas;
    private $infos;
    private $ans;
    private $update;
    private $errors;
    private $insert;
    private $count;
    private $select;
    private $delete;
    private $result;
    private $get_id;
    private $acces_path;

    function __construct()
    {

        $this->errors = new errors;
        $this->env = new \bin\epaphrodite\env\env;
        $this->datas = new \bin\database\datas\datas;
        $this->path = new \bin\epaphrodite\path\paths;
        $this->layouts = new \bin\epaphrodite\env\layouts;
        $this->msg = new \bin\epaphrodite\define\text_messages;
        $this->csrf = new \bin\epaphrodite\crf_token\token_csrf;
        $this->count = new \bin\database\requests\select\count;
        $this->session = new \bin\epaphrodite\auth\session_auth;
        $this->get_id = new \bin\database\requests\select\get_id;
        $this->select = new \bin\database\requests\select\select;
        $this->delete = new \bin\database\requests\delete\delete;
        $this->insert = new \bin\database\requests\insert\insert;
        $this->update = new \bin\database\requests\update\update;
        $this->acces_path = new \bin\database\requests\select\auth;
    }

    public function epaphrodite($html)
    {

        if (file_exists(_DIR_VIEWS_ . _DIR_ADMIN_TEMP_ . $html . '.html')) {


            /**
             * @param string $alert
             */
            $alert = '';

            /**
             * Modifier infos personnel des utilisateurs
             * 
             * @param string $view
             * @param array $array
             * @return mixed
             */
            if ($html === "users/modifier_infos_users_ep" && $this->get_id->autorisations('uinfos') === true || $html === "users/modifier_infos_users_ep" && $this->session->type() === 1) {

                $login = $this->session->login();

                if ($this->session->type() === 7) {

                    $login = $this->session->login();
                }

                if (isset($_POST['submit'])) {

                    $this->result = $this->update->infos_perso($_POST['nomprenom'], $_POST['email'], $_POST['contact']);
                    if ($this->result === true) {
                        $this->ans = $this->msg->answers('succes');
                        $alert = 'alert-success';
                    }
                    if ($this->result === false) {
                        $this->ans = $this->msg->answers('erreur');
                        $alert = 'alert-danger';
                    }
                }

                $this->render(
                    _DIR_ADMIN_TEMP_ . $html,
                    [
                        'alert' => $alert,
                        'env' => $this->env,
                        'path' => $this->path,
                        'data' => $this->datas,
                        'reponse' => $this->ans,
                        'messages' => $this->msg,
                        'forms' => $this->layouts->forms(),
                        'message' => $this->layouts->msg(),
                        'login' => $this->session->nomprenoms(),
                        'breadcrumb' => $this->layouts->breadcrumbs(),
                        'layouts' => $this->layouts->admin($this->session->type()),
                        'select' => $this->get_id->get_infos_users_by_login($login),
                        'layouts' => $this->layouts->admin($this->session->type())
                    ]
                );
            }

            /**
             * Modifier mot de passe d'un utilisateur
             * 
             * @param string $view
             * @param array $array
             * @return mixed
             */
            elseif ($html === "users/modifier_mot_de_passe_ep" && $this->get_id->autorisations('umdp') === true || $html === "users/modifier_mot_de_passe_ep" && $this->session->type() === 1) {

                if (isset($_POST['submit'])) {

                    $this->result = $this->update->changer_mdp($_POST['ancienmdp'], $_POST['newmdp'], $_POST['confirmmdp']);
                    if ($this->result === 1) {
                        $this->ans = $this->msg->answers('no-identic');
                        $alert = 'alert-danger';
                    }
                    if ($this->result === 2) {
                        $this->ans = $this->msg->answers('no-identic');
                        $alert = 'alert-danger';
                    }
                    if ($this->result === 3) {
                        $this->ans = $this->msg->answers('mdpwrong');
                        $alert = 'alert-danger';
                    }
                }

                $this->render(
                    _DIR_ADMIN_TEMP_ . $html,
                    [
                        'alert' => $alert,
                        'env' => $this->env,
                        'path' => $this->path,
                        'data' => $this->datas,
                        'reponse' => $this->ans,
                        'messages' => $this->msg,
                        'menus' => $this->get_id,
                        'forms' => $this->layouts->forms(),
                        'message' => $this->layouts->msg(),
                        'login' => $this->session->nomprenoms(),
                        'breadcrumb' => $this->layouts->breadcrumbs(),
                        'layouts' => $this->layouts->admin($this->session->type())
                    ]
                );
            }

            /**
             * Importation de tous les utilisateurs
             * 
             * @param string $view
             * @param array $array
             * @return mixed
             */
            elseif ($html === "users/import_des_utilisateurs_ep" && $this->get_id->autorisations('importusers') === true || $html === "users/import_des_utilisateurs_ep" && $this->session->type() === 1) {

                $state = $this->session->type() === 1 ? true : false;

                if (isset($_POST['submit'])) {
                    require_once _DIR_IMPORT_ . '/php-excel-reader/excel_reader2.php';
                    require_once _DIR_IMPORT_ . '/SpreadsheetReader.php';

                    if (!empty($_FILES['file']['name'])) {
                        $fichier_import = explode('.', $_FILES['file']['name']);
                        if ($fichier_import[1] === 'xls' || $fichier_import[1] === 'xlsx') {
                            $fichierautorise = ['application/vnd.ms-excel', 'text/xls', 'text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
                            if (in_array($_FILES["file"]["type"], $fichierautorise)) {
                                $lienfichier = _DIR_IMPORT_ . '/uploads/' . $_FILES['file']['name'];
                                move_uploaded_file($_FILES['file']['tmp_name'], $lienfichier);
                                $Reader = new \SpreadsheetReader($lienfichier);
                                $sheetCount = count($Reader->sheets());
                                for ($i = 0; $i < $sheetCount; $i++) {
                                    $Reader->ChangeSheet($i);
                                    foreach ($Reader as $Row) {

                                        $codeutilisateur = "";
                                        if (isset($Row[0])) {
                                            $codeutilisateur = $Row[0];
                                        }

                                        $this->result = $this->insert->add_users($codeutilisateur, $_POST['type_utilisateur']);

                                        if ($this->result === true) {
                                            $this->ans = $this->msg->answers('succes');
                                            $alert = 'alert-success';
                                        }
                                        if ($this->result === false) {
                                            $this->ans = $this->msg->answers('erreur');
                                            $alert = 'alert-danger';
                                        }
                                    }
                                }
                            }
                        } else {
                            $this->ans = $this->msg->answers('noformat');
                            $alert = 'alert-danger';
                        }
                    } else {
                        $this->ans = $this->msg->answers('fileempty');
                        $alert = 'alert-danger';
                    }
                }

                $this->render(
                    _DIR_ADMIN_TEMP_ . $html,
                    [
                        'alert' => $alert,
                        'state' => $state,
                        'env' => $this->env,
                        'path' => $this->path,
                        'data' => $this->datas,
                        'reponse' => $this->ans,
                        'messages' => $this->msg,
                        'forms' => $this->layouts->forms(),
                        'message' => $this->layouts->msg(),
                        'login' => $this->session->nomprenoms(),
                        'breadcrumb' => $this->layouts->breadcrumbs(),
                        'layouts' => $this->layouts->admin($this->session->type())
                    ]
                );
            }

            /**
             * Afficher la liste de tous les utilisateurs
             * 
             * @param string $view
             * @param array $array
             * @return mixed
             */
            elseif ($html === "users/liste_des_utilisateurs_ep" && $this->get_id->autorisations('listusers') === true || $html === "users/liste_des_utilisateurs_ep" && $this->session->type() === 1) {

                $page = isset($_GET['_p']) ? $_GET['_p'] : 1;
                $Nbreligne = 100;

                /**
                 * Activé ou desactivé un ou plusieurs utilisateur
                 */
                if (isset($_POST['__etat__'])) {

                    $this->result = $this->update->modifier_etat_users($_POST['__etat__']);
                    if ($this->result === true) {
                        $this->ans = $this->msg->answers('succes');
                        $alert = 'alert-success';
                    }
                    if ($this->result === false) {
                        $this->ans = $this->msg->answers('error');
                        $alert = 'alert-danger';
                    }
                }

                /**
                 * Reinatialiser le compte de un ou plusieurs utilisateurs
                 */
                if (isset($_POST['__reinit__'])) {

                    $this->result = $this->update->reinitialiser_mdp_user($_POST['__reinit__']);
                    if ($this->result === true) {
                        $this->ans = $this->msg->answers('succes');
                        $alert = 'alert-success';
                    }
                    if ($this->result === false) {
                        $this->ans = $this->msg->answers('error');
                        $alert = 'alert-danger';
                    }
                }

                if (isset($_GET['submitsearch']) && !empty($_GET['datasearch']) && $this->session->type() === 1) {

                    $total = 0;
                    $list = $this->get_id->get_infos_users_by_login($_GET['datasearch']);
                    if (!empty($list)) {
                        $total = 1;
                    }
                } elseif (empty($_GET['datasearch'])) {

                    $total = $this->count->count_all_users();
                    $list = $this->select->liste_users($page, $Nbreligne);
                }

                $this->render(
                    _DIR_ADMIN_TEMP_ . $html,
                    [
                        'path' => $this->path,
                        'env' => $this->env,
                        'messages' => $this->msg,
                        'csrf' => $this->csrf,
                        'reponse' => $this->ans,
                        'alert' => $alert,
                        'data' => $this->datas,
                        'pagecourante' => $page,
                        'effectif_total' => $total,
                        'forms' => $this->layouts->forms(),
                        'message' => $this->layouts->msg(),
                        'login' => $this->session->nomprenoms(),
                        'pages_total' => ceil(($total) / $Nbreligne),
                        'pagination' => $this->layouts->pagination(),
                        'breadcrumb' => $this->layouts->breadcrumbs(),
                        'layouts' => $this->layouts->admin($this->session->type()),
                        'liste_users' => $list,
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

class utilisateur extends utilisateur_app
{
    public function send($html)
    {

        $this->epaphrodite($html);
    }
}
