<?php

namespace bin\epaphrodite\auth;

use bin\epaphrodite\auth\SetUsersCookies;
use bin\epaphrodite\crf_token\csrf_secure;

class SetSessionSetting extends SetUsersCookies
{

    protected $crsf;
    private $session;
    protected $messages;
    protected $setting;
    protected $init = "";
    protected $cookievalue;
    private static bool $IS_SSL;

    /**
     * construct class
     * @return void
     */
    function __construct()
    {
        $this->session = new \bin\epaphrodite\auth\session_auth;
        $this->crsf = new \bin\epaphrodite\crf_token\gettokenvalue;
        $this->setting = new \bin\epaphrodite\heredia\SettingHeredia;
        $this->messages = new \bin\epaphrodite\define\SetTextMessages;
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
     * set session et cookies
     * 
     * @return void
     */
    public function session_if_not_exist():void
    {
        $name = $this->messages->answers('session_name');

        if (!self::hasStarted()) {

            self::$IS_SSL = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on';

            if (!empty($name)) {
                session_name($name);
            } elseif (self::$IS_SSL) {
                session_name('__Secure-PHPSESSID');
            }

            $this->setting->session_params()['domain'] = $_SERVER['SERVER_NAME'];
            $this->setting->session_params()['secure'] = self::$IS_SSL;

            session_set_cookie_params(array_merge( $this->setting->session_params(), $this->setting->others_options()));
            session_start();

            if ($this->session->login() === NULL && empty($this->session->token_csrf())) {
                $this->set_user_cookies($this->crsf->getvalue($this->init));
            }
        }
    }

}
