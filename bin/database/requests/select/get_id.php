<?php

namespace bin\database\requests\select;

use bin\database\config\process;

class get_id
{
    protected $datas;
    protected $session;
    protected $process;
    protected $json_datas;

    /**
     * Get class
     * @return void
     */
    function __construct()
    {
        $this->process = new process;
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
     * Request to select user right by module and 
     * 
     * @param string|null $module
     */
    public function modules(?string $module = null)
    {
        $result = false;
        $index = $module . ',' . $this->session->type();

        $json_arr = json_decode($this->json_datas, true);

        foreach ($json_arr as $key => $value) {
            if ($value['index_module'] == $index) {
                $result = true;
            }
        }

        return $result;
    }

    /** **********************************************************************************************
     * Request to select user right if exist
     * 
     * @return bool
     */
    public function if_right_exist($idtype_user, $pages)
    {

        $result = false;
        $index = $idtype_user . ',' . $pages;
        $json_arr = json_decode($this->json_datas, true);

        foreach ($json_arr as $key => $value) {
            if ($value['index_right'] == $index) {
                $result = true;
            }
        }

        return $result;
    }

    /************************************************************************************************
     * Request to select user right by user type
     */
    public function users_rights($idtype_user)
    {

        $result = [];
        $json_arr = json_decode($this->json_datas, true);

        foreach ($json_arr as $key => $value) {
            if ($value['idtype_user_rights'] == $idtype_user) {
                $result[] = $json_arr[$key];
            }
        }

        return $result;
    }

    /************************************************************************************************
     * Request to select user right by page type and @iduser
     */
    public function autorisations($pages)
    {
        $actions = false;
        $index = $this->session->type() . ',' . $pages;
        $json_arr = json_decode($this->json_datas, true);

        foreach ($json_arr as $key => $value) {

            if ($value['index_right'] == $index) {
                if ($value['autorisations'] == 1) {
                    $actions = true;
                } else {
                    $actions = false;
                }
            }
        }

        return $actions;
    }

    /** ********************************************************************************************** 
     * Request to select user right by user type
     * @param string|null $key
     * @return array
     */
    public function liste_menu(?string $key = null)
    {

        $result = [];
        $index = $key . ',' . $this->session->type();

        $json_arr = json_decode($this->json_datas, true);

        foreach ($json_arr as $key => $value) {
            if ($value['index_module'] === $index) {
                $result[] = $json_arr[$key];
            }
        }

        return $result;
    }

    /** **********************************************************************************************
     * Request to select users by login
     *
     * @param string|null $kecodey
     * @return array
     */
    public function get_infos_users_by_login(?string $login = null)
    {

        $sql = $this->QueryBuilder()
            ->table('user_bd')
            ->where('loginuser_bd')
            ->limit(0, 1)
            ->SQuery(NULL);

        $result = $this->process->select($sql, 's', [$login], false);

        return $result;
    }

    /** **********************************************************************************************
     * Request to select users by login
     *
     * @param string|null $kecodey
     * @return array
     */
    public function get_infos_by_lib_agence(?string $login = null)
    {

        $sql = $this->QueryBuilder()
            ->table('agence')
            ->where('lib_agence')
            ->limit(0, 1)
            ->SQuery(NULL);

        $result = $this->process->select($sql, 's', [$login], false);

        return $result;
    }

    /************************************************************************************************
     * Request to select all recent users actions of database
     * 
     */
    public function recents_actions()
    {

        $sql = $this->QueryBuilder()
            ->table('recente_actions')
            ->where('usersactions')
            ->orderBy('idrecenteactions', 'DESC')
            ->limit(0, 7)
            ->SQuery(NULL);

        $result = $this->process->select($sql, 's', [$this->session->login()], false);

        return $result;
    }
}
