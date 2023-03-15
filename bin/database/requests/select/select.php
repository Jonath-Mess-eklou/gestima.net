<?php

namespace bin\database\requests\select;

use bin\database\config\process;

class select
{

    protected $datas;
    protected $process;
    protected $session;

    /**
     * Get class
     * @return void
     */
    function __construct()
    {
        $this->process = new process;
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
     * Afficher la liste des utilisateurs
     *
     * @param integer $page
     * @param integer $Nbreligne
     * @return array
     */
    public function liste_users(int $page, int $Nbreligne)
    {

        $sql = $this->QueryBuilder()
            ->table('user_bd')
            ->limit((($page - 1) * $Nbreligne), $Nbreligne)
            ->orderby('type_user_bd', 'ASC')
            ->SQuery(NULL);

        $result = $this->process->select($sql, NULL, NULL, true);

        return $result;
    }
}
