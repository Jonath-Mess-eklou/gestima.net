<?php

namespace bin\epaphrodite\env;

use bin\epaphrodite\crf_token\csrf_secure;

class gestcookies
{

    protected $crsf;
    private $session;
    private $messages;
    protected $init = "";
    protected $cookievalue;

    /**
     * The flag to define if we work under SSL
     * @var bool
     * @access private
     */
    private static bool $IS_SSL;

    /**
     * construct class
     * @return void
     */
    function __construct()
    {
        $this->session = new \bin\epaphrodite\auth\session_auth;
        $this->crsf = new \bin\epaphrodite\crf_token\gettokenvalue;
        $this->messages = new \bin\epaphrodite\define\text_messages;
    }

    /**
     * Started
     * @return bool
     * @access private
     */
    private static function hasStarted(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    /**
     * Set main params
     * 
     * @return array
     */
    private static array $cookie_params = array(
        'lifetime' => 86400,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Strict',
    );

    /**
     * Set others options
     * 
     * @return array
     */
    private static array $others_options = array(
        'secure' => false,
    );

    /**
     * set session et cookies
     * 
     * @return void
     */
    public function session_if_not_exist(): void
    {
        $sessionname = $this->messages->answers('session_name');

        if (!self::hasStarted()) {

            self::$IS_SSL = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on';

            if (!empty($sessionname)) {
                session_name($sessionname);
            } elseif (self::$IS_SSL) {
                session_name('__Secure-PHPSESSID');
            }

            self::$cookie_params['domain'] = $_SERVER['SERVER_NAME'];
            self::$cookie_params['secure'] = self::$IS_SSL;

            session_set_cookie_params(array_merge(self::$cookie_params, self::$others_options));
            session_start();

            if ($this->session->login() === NULL && empty($this->session->token_csrf())) {

                $this->set_user_cookies($this->crsf->getvalue($this->init));
            }
        }
    }

    /**
     * Set cookies
     *
     * @param string $cookie_value
     * @return void
     */
    public function set_user_cookies($cookie_value): void
    {

        $arr_cookie_options = array(
            'expires' => time() + 60 * 60 * 24 * 30,
            'path' => '/',
            'domain' => '',
            'secure' => false,
            'httponly' => true,
            'samesite' => 'strict'
        );

        setcookie($this->messages->answers('token_name'), $cookie_value, $arr_cookie_options);

        $_COOKIE[$this->messages->answers('token_name')] = $cookie_value;
    }
}
