<?php

namespace bin\epaphrodite\others;


class gestion_interface
{

    private $interface;
    private $auth_interface;
    private $type_user_connecter;

    /** ************************************************************************************
     *Admin interface manager
     * @param string $key|null
     * @return string
     */
    public function admin(?int $key = null, ?string $url = null)
    {


        if ($key !== null) {

            $this->interface =
                [
                    1 => 'super_admin/',
                    2 => 'administrateur/',
                    3 => 'utilisateur/',
                ];

            return $url . $this->interface[$key];
        } else {
            return $this->login() . $url;
        }
    }

    /** 
     * Login interface manager
     */
    public function login()
    {

        $this->auth_interface = 'views/login/';

        return $this->auth_interface;
    }

    /** 
     * Login interface manager
     */
    public function main()
    {

        $this->auth_interface = 'views/index/';

        return $this->auth_interface;
    }
}
