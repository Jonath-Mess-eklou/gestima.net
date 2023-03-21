<?php

namespace bin\controllers\controllers;

use bin\controllers\render\errors;
use bin\epaphrodite\heredia\SwtchersHeredia;

class utilisateur_app extends SwtchersHeredia
{

    /**
     * declare variables
     *
     * @var \bin\epaphrodite\path\paths $url_path
     * @var \bin\database\users_right\datas_array $datas
     * @var \bin\epaphrodite\auth\session_auth $path_session
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
        $this->count = new \bin\database\requests\select\count;
        $this->session = new \bin\epaphrodite\auth\session_auth;
        $this->get_id = new \bin\database\requests\select\get_id;
        $this->msg = new \bin\epaphrodite\define\SetTextMessages;
        $this->select = new \bin\database\requests\select\select;
        $this->delete = new \bin\database\requests\delete\delete;
        $this->insert = new \bin\database\requests\insert\insert;
        $this->update = new \bin\database\requests\update\update;
        $this->acces_path = new \bin\database\requests\select\auth;
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
            $ans = '';

            /**
             * Modifier infos personnel des utilisateurs
             * 
             * @param string $view
             * @param array $array
             * @return mixed
             */
            if ( SELF::SwitcherPages( 'users/modifier_infos_users' , $html ) === true ) {

                $login = $this->session->login();

                if ($this->session->type() === 7) {

                    $login = $this->session->login();
                }

                if (isset($_POST['submit'])) {

                    $this->result = $this->update->infos_perso($_POST['nomprenom'], $_POST['email'], $_POST['contact']);
                    if ($this->result === true) {
                        $ans = $this->msg->answers('succes');
                        $alert = 'alert-success';
                    }
                    if ($this->result === false) {
                        $ans = $this->msg->answers('erreur');
                        $alert = 'alert-danger';
                    }
                }

                SELF::rooter()->target( _DIR_ADMIN_TEMP_ . $html )->content( [ 'reponse' => $ans, 'alert' => $alert, 'env' => $this->env, 'data' => $this->datas, 'select' => $this->get_id->get_infos_users_by_login($login) ],true)->get();
            }

            /**
             * Modifier mot de passe d'un utilisateur
             * 
             * @param string $view
             * @param array $array
             * @return mixed
             */
            if (  SELF::SwitcherPages( 'users/modifier_mot_de_passe' , $html ) === true ) {

                if (isset($_POST['submit'])) {

                    $this->result = $this->update->changer_mdp($_POST['ancienmdp'], $_POST['newmdp'], $_POST['confirmmdp']);
                    if ($this->result === 1) {
                        $ans = $this->msg->answers('no-identic');
                        $alert = 'alert-danger';
                    }
                    if ($this->result === 2) {
                        $ans = $this->msg->answers('no-identic');
                        $alert = 'alert-danger';
                    }
                    if ($this->result === 3) {
                        $ans = $this->msg->answers('mdpwrong');
                        $alert = 'alert-danger';
                    }
                }

                SELF::rooter()->target( _DIR_ADMIN_TEMP_ . $html )->content( [ 'reponse' => $ans, 'alert' => $alert, 'env' => $this->env, 'data' => $this->datas, ],true)->get();
            }

            /**
             * Importation de tous les utilisateurs
             * 
             * @param string $view
             * @param array $array
             * @return mixed
             */
            if ( SELF::SwitcherPages( 'users/import_des_utilisateurs' , $html ) === true ) {

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
                                            $ans = $this->msg->answers('succes');
                                            $alert = 'alert-success';
                                        }
                                        if ($this->result === false) {
                                            $ans = $this->msg->answers('erreur');
                                            $alert = 'alert-danger';
                                        }
                                    }
                                }
                            }
                        } else {
                            $ans = $this->msg->answers('noformat');
                            $alert = 'alert-danger';
                        }
                    } else {
                        $ans = $this->msg->answers('fileempty');
                        $alert = 'alert-danger';
                    }
                }

                SELF::rooter()->target( _DIR_ADMIN_TEMP_ . $html )->content( [ 'state' => $state, 'reponse' => $ans, 'alert' => $alert, 'env' => $this->env, 'data' => $this->datas, ],true)->get();
            }

            /**
             * Afficher la liste de tous les utilisateurs
             * 
             * @param string $view
             * @param array $array
             * @return mixed
             */
            if (  SELF::SwitcherPages( 'users/liste_des_utilisateurs' , $html ) === true ) {

                $page = isset($_GET['_p']) ? $_GET['_p'] : 1;
                $Nbreligne = 100;

                /**
                 * Activé ou desactivé un ou plusieurs utilisateur
                 */
                if (isset($_POST['__etat__'])) {

                    $this->result = $this->update->modifier_etat_users($_POST['__etat__']);
                    if ($this->result === true) {
                        $ans = $this->msg->answers('succes');
                        $alert = 'alert-success';
                    }
                    if ($this->result === false) {
                        $ans = $this->msg->answers('error');
                        $alert = 'alert-danger';
                    }
                }

                /**
                 * Reinatialiser le compte de un ou plusieurs utilisateurs
                 */
                if (isset($_POST['__reinit__'])) {

                    $this->result = $this->update->reinitialiser_mdp_user($_POST['__reinit__']);
                    if ($this->result === true) {
                        $ans = $this->msg->answers('succes');
                        $alert = 'alert-success';
                    }
                    if ($this->result === false) {
                        $ans = $this->msg->answers('error');
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

                SELF::rooter()->target( _DIR_ADMIN_TEMP_ . $html )->content( [ 'reponse' => $ans, 'alert' => $alert, 'env' => $this->env, 'data' => $this->datas,'pagecourante' => $page, 'effectif_total' => $total,'pages_total' => ceil(($total) / $Nbreligne),'liste_users' => $list,],true)->get();

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
