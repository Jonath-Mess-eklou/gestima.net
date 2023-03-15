<?php

namespace bin\epaphrodite\crf_token;

use bin\epaphrodite\crf_token\gettokenvalue;
use bin\epaphrodite\crf_token\validate_token;

class token_csrf{

    protected $csrf;
    protected $token_value;

    function __construct()
    {
        $this->csrf = new validate_token();
        $this->token_value = new gettokenvalue();
    }

    /**
     * Token csrf input
     * 
     *  @return mixed 
     * */    
    public function input_field(){

        $input_token = "<input type='hidden' name='token_csrf' value='".$this->token_value->getvalue()."' required \>";
        echo $input_token;
    }  

    /**
     * csrf verification process...
     * 
     * @return bool
     */
    private function process(){

        return $this->csrf->token_verify();
    }

    /**
     * If csrf exist
     */
    public function tocsrf(){

        if(isset($_POST['token_csrf'])){ if($this->process()===true){ return true; }else{ return false;} }else{ return true; }

    }

}