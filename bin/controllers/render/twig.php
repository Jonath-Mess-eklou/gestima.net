<?php

namespace bin\controllers\render;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class twig {

    private $loader;
    private $twig;
    
    /**
     * Twig path FilesystemLoader
     *
     * @return mixed
    */    
    private function twig_filseystem(){
        
        $this->loader = new FilesystemLoader ( _DIR_VIEWS_ );

        return $this->loader;
    }

    /**
     * Twig path Environment
     * 
     * @return mixed
    */    
    public function twig_env(){

        $this->twig = new Environment ( $this->twig_filseystem() , [ 'cache' =>false ]);

        return $this->twig;
    }

    /**
     * Twig render
     *
     * @param string $view
     * @param array $array
     * 
     * @return mixed
     */ 
    public function render( string $view , array $array ){
        
      echo $this->twig_env()->render( $view.'.html', $array );

    }    


}