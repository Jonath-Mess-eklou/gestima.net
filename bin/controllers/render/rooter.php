<?php

namespace bin\controllers\render;

use bin\controllers\render\twig;

class rooter extends twig
{

    private $content;
    private $target;
    private $setting;

    function __construct()
    {
        $this->setting = new \bin\epaphrodite\heredia\SettingHeredia;
    }

    /**
     * target
     *
     * @param array $target
     * @return self
     */
    public function target(string $target):self
    {

        $this->target =  $target;

        return $this;
    }

    /**
     * Find content
     *
     * @param array $content
     * @return self
     */
    public function content( $content = [] , ?bool $switch = false ):self
    {

        $init = $switch === true ? $this->setting->admin_init() : $this->setting->main_init();

        $this->content = array_merge( $content , $init );

        return $this;
    }    


    /**
     * run page
     *
     * @return self
     */    
    public function get(){

        $this->render( "{$this->target}" , $this->content );

    }



}