<?php

namespace bin\database\config;

use bin\database\config\database;

class process
{

    private $connexion;

    /**
     * *****************************************************************************************************************************
     * Processed all select request
     * @param string $sql
     * @param string|null $param
     * @param array|null $datas
     * @param boolean|null $etat
     * @param int|1 $bd
     * 
     * @return void
     */
    public function select($sql, ?string $param = null, ?array $datas = null, ?bool $etat = false, ?int $bd = 1)
    {

        $result = $this->connexion()->select($sql, $param, $datas, $bd);

        if ($etat === true) {
            $this->connexion->closeConnection($bd);
        }

        return $result;
    }

    /**
     * *****************************************************************************************************************************
     * Processed all update request
     *
     * @param string $sql
     * @param string|null $param
     * @param array|null $datas
     * @param boolean|null $etat
     * @param int|1 $bd
     * 
     * @return void
     */
    public function update($sql, ?string $param = null, ?array $datas = null, ?bool $etat = false, ?int $bd = 1)
    {

        $result = $this->connexion()->update($sql, $param, $datas, $bd);

        if ($etat === true) {
            $this->connexion->closeConnection($bd);
        }

        return $result;
    }

    /**
     * *****************************************************************************************************************************
     * Processed all insert request
     *
     * @param string $sql
     * @param string|null $param
     * @param array|null $datas
     * @param boolean|null $etat
     * @param int|1 $bd
     * 
     * @return void
     */
    public function insert($sql, ?string $param = null, ?array $datas = null, ?bool $etat = false, ?int $bd = 1)
    {

        $result = $this->connexion()->insert($sql, $param, $datas, $bd);


        if ($etat === true) {
            $this->connexion->closeConnection($bd);
        }

        return $result;
    }

    /**
     * *****************************************************************************************************************************
     * Processed all delete request
     *
     * @param string $sql
     * @param string|null $param
     * @param array|null $datas
     * @param boolean|null $etat
     * @param int|1 $bd
     * 
     * @return void
     */
    public function delete($sql, ?string $param = null, ?array $datas = null, ?bool $etat = false, ?int $bd = 1)
    {

        $result = $this->connexion()->delete($sql, $param, $datas, $bd);

        if ($etat === true) {
            $this->connexion->closeConnection($bd);
        }

        return $result;
    }

    /**
     * *****************************************************************************************************************************
     * Get connexion of database
     */
    private function connexion()
    {

        return $this->connexion = new database();
    }
}
