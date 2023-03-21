<?php

namespace bin\controllers\render;

use bin\controllers\switchers\GetControllers;

class geturlspathd0f2fc4b2b97c18300fa420cf03c7028cd6a692234b0563c747665bed1d1b075
{
    private $session;
    private $generated;
    private $interface_manager;
    private $urlfound;
    private $url;
    private $paths;
    private $env;
    private $switchers;

    /**
     * Get class
     * @return void
     */
    public function __construct()
    {
        $this->paths = new \bin\epaphrodite\path\paths;
        $this->session = new \bin\epaphrodite\auth\session_auth;
        $this->generated = new \bin\epaphrodite\auth\SetSessionSetting;
        $this->switchers = new \bin\controllers\switchers\GetControllers;
        $this->interface_manager = new \bin\epaphrodite\others\gestion_interface;
        $this->env = new \bin\controllers\render\methodd0f2fc4b2b97c18300fa420cf03c7028cd6a692234b0563c747665bed1d1b075;
    }

    /**
     * Check and send to controller
     *
     * @var \bin\epaphrodite\env\gestion_interface $interface_manager
     * @var \bin\epaphrodite\auth\session_auth $session
     * @var string $url
     * @var $this $this
     * @return string
     */
    private function geturi()
    {

        if (isset($_GET[$this->env::GET()]) && $_GET[$this->env::GET()][-1] === "/") {
            $this->urlfound = $_GET[$this->env::GET()];
        } else {

            $this->urlfound = 'dashboard/';
        }

        return  $this->paths->href_slug($this->urlfound);
    }

    public function provider(?array $url = null){

        return $this->session->id() !== NULL && count($url) > 1 ? $url[0] . '/' . $url[1] . _MAIN_EXTENSION_ : $url[1] . _MAIN_EXTENSION_;

    }

    /* 
        Lancer l'application 
    */
    public function runAppd0f2fc4b2b97c18300fa420cf03c7028cd6a692234b0563c747665bed1d1b075()
    {

        $this->url = $this->geturi();

        /**
         * Set cookies and start user session
         * 
        */
        $this->generated->session_if_not_exist();

        /*
          * Get user authentification page or destroy session
        */
        if ($this->url === "views/login/" || $this->url === "logout/") {

            $this->session->deconnexion();

            $this->url = $this->interface_manager->login();
        }

        /*
          * Get user authentification page or destroy session
        */
        if ($this->url === "dashboard/" && $this->session->id() === NULL) {

            $this->session->deconnexion();

            $this->url = $this->interface_manager->main();
        }

        /*
          * Get user dashbord page
        */
        if ($this->url === "dashboard/" && $this->session->token_csrf() !== NULL && $this->session->id() !== NULL && $this->session->login() !== NULL) {

            $this->url = $this->interface_manager->admin($this->session->type(), $this->url);
        }

        /*
          * Return true user page
        */
        $this->switchers->SwitchMainControllers( explode('/', $this->url) , $this->provider(explode('/', $this->url)) );
    }

}
