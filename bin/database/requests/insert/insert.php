<?php

namespace bin\database\requests\insert;

use \bin\epaphrodite\env\env;
use bin\database\config\process;
use \bin\epaphrodite\env\verify_chaine;
use \bin\database\requests\select\get_id;

class insert
{

    private $path;
    private $env;
    private $datas;
    private $get_id;
    private $process;
    private $session;
    private $verify_if_is;

    /**
     * Get class
     * @return void
     */
    function __construct()
    {
        $this->env = new env;
        $this->get_id = new get_id;
        $this->process = new process;
        $this->verify_if_is = new verify_chaine;
        $this->env = new \bin\epaphrodite\env\env;
        $this->datas = new \bin\database\datas\datas;
        $this->session = new \bin\epaphrodite\auth\session_auth;
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

    /**
     * Ajouter des droits utilisateurs
     * index ( module , type_user , idpage , action)
     * @param int|null $idtype_users
     * @param string|null $pages
     * @param string|null $actions
     * @return bool
     */
    public function users_rights(?int $idtype_users = null, ?string $pages = null,  ?string  $actions = null)
    {

        if (!empty($idtype_users) && !empty($pages) && $this->get_id->if_right_exist($idtype_users, $pages) === false) {

            $json_datas = file_get_contents(_DIR_DATAS_ . 'json_data.json');

            $save_right = json_decode($json_datas, true);

            $save_right[] = array(
                'iduser_rights' => count($save_right) + 1,
                'idtype_user_rights' => $idtype_users,
                'idpages' => $pages,
                'autorisations' => $actions,
                'modules' => $this->datas->yedidiah($pages, 'apps'),
                'index_module' => $this->datas->yedidiah($pages, 'apps') . ',' . $idtype_users,
                'index_right' => $idtype_users . ',' . $pages,
            );

            file_put_contents(_DIR_DATAS_ . 'json_data.json', json_encode($save_right));

            $actions = "Attribuer un droit au groupe d'utilisateur : " . $this->datas->user($idtype_users);
            $this->action_recente($actions);

            return true;
        } else {
            return false;
        }
    }

    /**
     * Ajouter des droits utilisateurs dans le systeme
     *
     * @param string|null $login
     * @param int|null $idtype
     * @return bool
     */
    public function add_users(?string $login = null, ?int $idtype = null)
    {

        if (!empty($login) && !empty($idtype) && count($this->get_id->get_infos_users_by_login($login)) < 1) {

            $sql = $this->QueryBuilder()
                ->table('user_bd')
                ->insert(' loginuser_bd , mdpuser_bd , type_user_bd ')
                ->values(' ? , ? , ? ')
                ->IQuery();

            $this->process->insert($sql, 'sss', [$this->env->no_space($login), hash('gost', $login . '@epaph'), $idtype], false, 1);

            $actions = "Ajout d'un utilisateur : " . $login;

            $this->action_recente($actions);

            return true;
        } else {
            return false;
        }
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
