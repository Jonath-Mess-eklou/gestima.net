<?php

namespace bin\controllers\render;

use bin\controllers\render\twig;

class errors extends twig
{

    private $msg;
    private $paths;
    private $layouts;
    private $session;

    /**
     * Get class
     * @return void
     */
    function __construct()
    {
        $this->paths = new \bin\epaphrodite\path\paths;
        $this->layouts = new \bin\epaphrodite\env\layouts;
        $this->msg = new \bin\epaphrodite\define\text_messages;
        $this->session = new \bin\epaphrodite\auth\session_auth;
    }

    /**
     * Page erreur 404
     *
     * @return exit
     */
    public function error_404()
    {
        $this->render(
            'errors/404',
            [
                'back' => $this->back(),
                'layouts' => $this->layouts->errors(),
            ]
        );
        die();
    }

    /**
     * Page erreur 403
     *
     * @return exit
     */
    public function error_403()
    {
        $this->render(
            'errors/403',
            [
                'back' => $this->back(),
                'layouts' => $this->layouts->errors(),
            ]
        );
        die();
    }

    /**
     * Page erreur 419 
     *
     * @return exit
     */
    public function error_419()
    {

        $this->render(
            'errors/419',
            [
                'back' => $this->back(),
                'layouts' => $this->layouts->errors(),
            ]
        );

        $this->session->deconnexion();
        die();
    }

    /**
     * Page erreur 500
     * 
     * @return exit
     */
    public function error_500($errorType)
    {

        $this->render(
            'errors/500',
            [
                'back' => $this->back(),
                'type' => $errorType,
                'layouts' => $this->layouts->errors(),
            ]
        );
        die();
    }

    /**
     * back manager
     * 
     * @return exit
     */
    private function back()
    {

        $path_init = $this->paths->gethost();
        $path_connect = $this->paths->dashboard();

        if ($this->session->login() == NULL) {
            return $path_init;
        } else {
            return $path_connect;
        }
    }
}
