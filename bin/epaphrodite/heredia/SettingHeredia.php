<?php

namespace bin\epaphrodite\heredia;

class SettingHeredia{

    private $msg;
    private $paths;
    private $session;
    private $layouts;


    function __construct()
    {
        $this->paths = new \bin\epaphrodite\path\paths;
        $this->layouts = new \bin\epaphrodite\env\layouts;
        $this->session = new \bin\epaphrodite\auth\session_auth;
        $this->msg = new \bin\epaphrodite\define\SetTextMessages;
    }

        /**
     * Set main_init layouts params
     * 
     * @return array
     */
    public function main_init():array
    {
        return [
            'path' => $this->paths,
            'messages' => $this->msg,
            'forms' => $this->layouts->forms(),
            'message' => $this->layouts->msg(),
            'layouts' => $this->layouts->main(),
            'login' => $this->session->nomprenoms(),
            'pagination' => $this->layouts->pagination(),
            'breadcrumb' => $this->layouts->breadcrumbs(),
        ];
    } 

    /**
     * Set admin_init layouts params
     * 
     * @return array
     */
    public function admin_init():array 
    {
        return [
            'path' => $this->paths,
            'messages' => $this->msg,
            'message' => $this->layouts->msg(),
            'forms' => $this->layouts->forms(),
            'login' => $this->session->nomprenoms(),
            'pagination' => $this->layouts->pagination(),
            'breadcrumb' => $this->layouts->breadcrumbs(),
            'layouts' => $this->layouts->admin($this->session->type()),
        ];   
    } 

    /**
     * Set main params
     * 
     * @return array
     */    
    public function coookies():array
    {
        return [
            'expires' => time() + 60 * 60 * 24 * 30,
            'path' => '/',
            'domain' => '',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'strict'
        ];   
    } 

    /**
     * Set main params
     * 
     * @return array
     */
    public function session_params ():array
    {
        return [
            'lifetime' => 86400,
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Strict',
        ];
    }

    /**
     * Set others options
     * 
     * @return array
     */
    public function others_options ():array
    {
       return ['secure' => true];
    }   

}
