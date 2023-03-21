<?php

namespace bin\epaphrodite\auth;

class SetUsersCookies{

    protected $setting;
    protected $messages;

    function __construct(){
        $this->setting = new \bin\epaphrodite\heredia\SettingHeredia;
        $this->messages = new \bin\epaphrodite\define\SetTextMessages;
    }
    
    /**
     * Set cookies
     *
     * @param string $cookie_value
     * @return void
     */
    public function set_user_cookies($cookie_value):void
    {
        setcookie($this->messages->answers('token_name'), $cookie_value, $this->setting->coookies());

        $_COOKIE[$this->messages->answers('token_name')] = $cookie_value;
    }

}