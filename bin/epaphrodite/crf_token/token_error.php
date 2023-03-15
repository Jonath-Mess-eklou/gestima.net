<?php

namespace bin\epaphrodite\crf_token;

use bin\controllers\render\errors;

class token_error extends errors{
    
    public function send(){

        $this->error_419(); 

    }

}