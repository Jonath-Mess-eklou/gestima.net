<?php

namespace bin\database\config;

use PDO;
use bin\database\config\config;

class database extends config
{


    /* 
        Construct database connection 
    */
    public function get_connexion(int $db)
    {

        return $this->epaphrodite_get_connexion($db);
    }


    /* 
        Disconnexion 
    */
    public function closeConnection($bd)
    {
        return  NULL;
    }

    /**
     * SQL request to select  
     * 
     * @param string|null $sql_chaine
     * @param string|null $param
     * @param array|null $datas
     * @param int|1 $bd
     * 
     */
    public function select($sql_chaine, $param, $datas = array(), ?int $bd = 1)
    {

        $request = $this->get_connexion($bd)->prepare($sql_chaine);

        if (!empty($param)) {

            foreach ($datas as $k => &$v) {
                $request->bindParam($k + 1, $datas[$k], PDO::PARAM_STR);
            }
        }

        $request->execute();

        return $request->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * SQL request to insert  
     * @param string|null $sql_chaine
     * @param string|null $param
     * @param array|null $datas
     * @param int|1 $bd
     * 
     */
    public function insert($sql_chaine, $param, $datas = array(), ?int $db = 1)
    {

        $request = $this->get_connexion($db)->prepare($sql_chaine);

        if (!empty($param)) {

            foreach ($datas as $k => &$v) {
                $request->bindParam($k + 1, $datas[$k], PDO::PARAM_STR);
            }
        }

        $result = $request->execute();

        return $result;
    }

    /**
     * SQL request to delete  
     * @param string|null $sql_chaine
     * @param string|null $param
     * @param array|null $datas
     * @param int|1 $bd
     */
    public function delete($sql_chaine, $param, $datas = array(), ?int $db = 1)
    {
        $request = $this->get_connexion($db)->prepare($sql_chaine);

        if (!empty($param)) {

            foreach ($datas as $k => &$v) {
                $request->bindParam($k + 1, $datas[$k], PDO::PARAM_STR);
            }
        }

        $request = $request->execute();

        return $request;
    }

    /**
     * SQL request to update 
     * 
     * @param string|null $sql_chaine
     * @param string|null $param
     * @param array|null $datas
     * @param int|1 $bd
     */
    public function update($sql_chaine, $param, $datas = array(), ?int $db = 1)
    {
        $request = $this->get_connexion($db)->prepare($sql_chaine);

        if (!empty($param)) {

            foreach ($datas as $k => &$v) {
                $request->bindParam($k + 1, $datas[$k], PDO::PARAM_STR);
            }
        }

        $result = $request->execute();

        return $result;
    }
}
