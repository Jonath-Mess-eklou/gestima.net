<?php

namespace bin\epaphrodite\crf_token;

class gettokenvalue
{

    private $crf_token = '';
    private $cookievalue = '';
    private $token = '';
    private $tokensession = '';
    private $messages;


    public function userconnecter_token()
    {
        $this->messages = new \bin\epaphrodite\define\text_messages();
        $this->tokensession = isset($_COOKIE[$this->messages->answers('token_name')]) ? $_COOKIE[$this->messages->answers('token_name')] : NULL;

        return $this->tokensession;
    }

    private function generateurtoken($length)
    {
        $this->token = '';
        if ($this->userconnecter_token() === NULL) {
            $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            for ($i = 0; $i < $length; $i++) {
                $this->token .= $chars[rand(0, strlen($chars) - 1)];
            }
        } else {
            $this->token = $this->userconnecter_token();
        }
        return $this->token;
    }

    public function getvalue()
    {
        $this->crf_token = $this->generateurtoken(70);
        return $this->crf_token;
    }
}
