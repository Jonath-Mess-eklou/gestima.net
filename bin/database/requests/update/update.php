<?php

namespace bin\database\requests\update;

use bin\database\config\process;
use \bin\epaphrodite\env\verify_chaine;
use \bin\database\requests\select\get_id;

class update
{

    private $path;
    private $get_id;
    protected $datas;
    protected $session;
    protected $process;
    protected $json_datas;
    private $desconnect;
    private $verify_if_is;


    /**
     * Get class
     * @return void
     */
    function __construct()
    {
        $this->get_id = new get_id;
        $this->process = new process;
        $this->verify_if_is = new verify_chaine;
        $this->path = new \bin\epaphrodite\path\paths;
        $this->datas = new \bin\database\datas\datas;
        $this->session = new \bin\epaphrodite\auth\session_auth;
        $this->json_datas = file_get_contents(_DIR_DATAS_ . 'json_data.json');
    }

    /************************************************************************************************
     * Querybilder constructor
     *
     * @return \bin\database\querybilder\querybuilder
     */
    private function QueryBuilder(): \bin\database\querybilder\querybuilder
    {
        return new \bin\database\querybilder\querybuilder();
    }

    /** **********************************************************************************************
     * Request to update users rights
     * 
     * @param int|null $idtype_user
     * @param int|null $etat
     * @return bool
     */
    public function users_rights(?int $idtype_user = null, ?int $etat = null)
    {

        $json_arr = json_decode($this->json_datas, true);

        foreach ($json_arr as $key => $value) {

            if ($value['iduser_rights'] == $idtype_user) {

                $json_arr[$key]['autorisations'] = $etat;
            }
        }

        file_put_contents(_DIR_DATAS_ . 'json_data.json', json_encode($json_arr));

        return true;
    }


    /**
     * Changer mot de passe de l'utilisateur
     *
     * @param string $ancienmdp
     * @param string $newmdp
     * @param string $confirmdp
     * @return void
     */
    public function changer_mdp(string $ancienmdp, string $newmdp, string $confirmdp)
    {

        if (hash('gost', $newmdp) === hash('gost', $confirmdp)) {
            if (!empty($this->verify_user())) {

                if ($this->verify_user()[0]['mdpuser_bd'] === hash('gost', $ancienmdp)) {

                    $sql = $this->QueryBuilder()
                        ->table('user_bd')
                        ->set(['mdpuser_bd'])
                        ->where('iduser_bd')
                        ->UQuery();

                    $this->process->update($sql, 'ss', [hash('gost', $newmdp), $this->session->id()], false);

                    $actions = "Changement de mot de passe : " . $this->session->login();
                    $this->action_recente($actions);

                    $this->desconnect = $this->path->logout();

                    header("Location: $this->desconnect ");
                } else {
                    return 3;
                }
            } else {
                return 2;
            }
        } else {
            return 1;
        }
    }

    /**
     * Changer les informations de l'utilisateur
     *
     * @param string $nomprenoms
     * @param string $email
     * @param string $matricule
     * @param int $number
     * @return void
     */
    public function infos_perso(string $nomprenoms, string $email, string $number)
    {

        if ($this->verify_if_is->only_number($number, 11) === false) {

            $sql = $this->QueryBuilder()
                ->table('user_bd')
                ->set(['contact_user', 'email_user', 'nomprenoms_user'])
                ->where('iduser_bd')
                ->UQuery();

            $this->process->update($sql, 'ssss', [$number, $email, $nomprenoms, $this->session->id()], false);

            $_SESSION["nom_prenoms"] = $nomprenoms;

            $_SESSION["contact"] = $number;

            $_SESSION["email"] = $email;

            $actions = "Modification des informations personnelles : " . $this->session->login();
            $this->action_recente($actions);

            $this->desconnect = $this->path->dashboard();

            header("Location: $this->desconnect ");
        } else {
            return false;
        }
    }

    /**
     * Modifier l'etat d'un utilisateur
     *
     * @param integer $type_user
     * @param integer $id_user
     * @return void
     */
    public function modifier_etat_users(string $login)
    {

        $get_user_datas = $this->get_id->get_infos_users_by_login($login);

        if (!empty($get_user_datas)) {

            $state = !empty($get_user_datas[0]['etat_userbd']) ? 0 : 1;

            $etat_exact = "Fermeture";

            if ($state == 1) {
                $etat_exact = "Ouverture";
            }

            $sql = $this->QueryBuilder()
                ->table('user_bd')
                ->set(['etat_userbd'])
                ->where('loginuser_bd')
                ->UQuery();

            $this->process->update($sql, 'ss', [$state, $get_user_datas[0]['loginuser_bd']], true);

            $actions = $etat_exact . " du compte de l'utilisateur : " . $get_user_datas[0]['loginuser_bd'];
            $this->action_recente($actions);

            return true;
        } else {
            return false;
        }
    }

    /**
     * Reinitialiser le mot de passe d'un utilisateur
     *
     * @param integer $type_user
     * @param integer $id_user
     * @return void
     */
    public function reinitialiser_mdp_user(string $code_user)
    {

        $sql = $this->QueryBuilder()
            ->table('user_bd')
            ->set(['mdpuser_bd'])
            ->where('loginuser_bd')
            ->UQuery();

        $this->process->update($sql, 'ss', [hash('gost', $code_user . '@epaph'), $code_user], false);

        $actions = "Réinitialisation de mot de passe de l'utilisateur : " . $code_user;
        $this->action_recente($actions);

        return true;
    }

    /**
     * Verifier l'existence d'un utilisateur
     *
     * @return void
     */
    private function verify_user()
    {

        $sql = $this->QueryBuilder()
            ->table('user_bd')
            ->where('iduser_bd')
            ->SQuery(NULL);

        $result = $this->process->select($sql, 's', [$this->session->id()], false);

        return $result;
    }


    /**
     * Enregistrer les actions recentes
     * 
     * @param string|null $action
     * @return bool
     */
    public function action_recente(?string $action = null)
    {

        $sql = $this->QueryBuilder()
            ->table('recente_actions ')
            ->insert('usersactions , dateactions , libactions')
            ->values(' ? , ? , ? ')
            ->IQuery();

        $result = $this->process->select($sql, 'sss', [$this->session->login(), date("Y-m-d H:i:s"), $action], false);

        return true;
    }
}
