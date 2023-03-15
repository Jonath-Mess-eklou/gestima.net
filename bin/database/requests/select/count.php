<?php

namespace bin\database\requests\select;

use \bin\database\config\process;
use bin\epaphrodite\auth\session_auth;

class count
{

    private $request;

    private $process;
    private $session;
    private $env;
    private $datas;
    private $chats_datas;
    /**
     * Get class
     * 
     * @return void
     */
    function __construct()
    {
        $this->process = new process;
        $this->session = new session_auth;
        $this->datas = new \bin\database\datas\datas;
        $this->env = new \bin\epaphrodite\env\env;
    }

    /**
     * Querybilder constructor
     *
     * @return \bin\database\querybilder\querybuilder
     */
    private function QueryBuilder(): \bin\database\querybilder\querybuilder
    {
        return new \bin\database\querybilder\querybuilder();
    }

    /* 
      Get total number of user bd
    */
    public function count_all_users()
    {
        $sql = $this->QueryBuilder()
            ->table('user_bd')
            ->SQuery("COUNT(*) AS nbre");
        $result = $this->process->select($sql, NULL, NULL, false);

        return $result[0]['nbre'];
    }

    /* 
      Get total number of user bd
    */
    public function count_all_agences()
    {
        $sql = $this->QueryBuilder()
            ->table('agence')
            ->SQuery("COUNT(*) AS nbre");
        $result = $this->process->select($sql, NULL, NULL, false);

        return $result[0]['nbre'];
    }
}
