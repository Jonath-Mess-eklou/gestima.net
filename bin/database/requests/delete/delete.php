<?php

namespace bin\database\requests\delete;

use bin\database\config\process;

class delete
{

    private $datas;
    private $process;
    private $session;
    private $json_datas;
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

    /************************************************************************************************
     * Request to delete users right by @id
     */
    public function users_rights($idright)
    {

        $json_arr = json_decode($this->json_datas, true);

        foreach ($json_arr as $key => $value) {

            if ($value['iduser_rights'] == $idright) {
                unset($json_arr[$key]);
            }
        }

        file_put_contents(_DIR_DATAS_ . 'json_data.json', json_encode($json_arr));

        return true;
    }

    /************************************************************************************************
     * Request to delete users right by @id
     */
    public function empty_users_right($typeusers)
    {

        $json_arr = json_decode($this->json_datas, true);

        foreach ($json_arr as $key => $value) {

            if ($value['idtype_user_rights'] == $typeusers) {
                unset($json_arr[$key]);
            }
        }

        file_put_contents(_DIR_DATAS_ . 'json_data.json', json_encode($json_arr));

        return true;
    }

    /************************************************************************************************
     * Request to delete all users of database
     */
    public function users()
    {

        $sql = $this->QueryBuilder()
            ->table('user_bd')
            ->DQuery(NULL);

        $result = $this->process->delete($sql, null, null, true);

        return $result;
    }
}
