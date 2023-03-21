<?php

namespace bin\epaphrodite\constant;

class EpaphClass{

    public static function errors(){

        return new \bin\controllers\render\errors;
    }

    public static function crsf()
    {
        return new \bin\epaphrodite\crf_token\token_csrf;
    }

    public static function auth(){

        return new \bin\epaphrodite\auth\session_auth;
    }  

}