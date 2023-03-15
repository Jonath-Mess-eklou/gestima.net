<?php

namespace bin\epaphrodite\env;

class verify_chaine{

    private $verificaracteres;
    private $verifinbrecaractere;

    /* 
      Don't content number
    */      
    private function without_number($variable)
    {
        if(preg_match("/[<>_abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ±˜`#*-+§£∞§•¶ªº‘“æ«…™πå∑´®†˜ç¬¥¨ˆøπ¬˚¬∆˙©ƒßå∂≈√∫µ÷≥≤˜∆˙∂=;!^&?,.()%:'|{µ@!}$]/", $variable))
        {
            return true;}
        else{
            return false;}
    }

    /* 
      Don't content character
    */      
    private function without_characters($variable)
    {
        if(preg_match("/[<>_1234567890±˜`#*-+§£∞§•¶ªº‘“æ«…™πå∑´®†˜ç¬¥¨ˆøπ¬˚¬∆˙©ƒßå∂≈√∫µ÷≥≤˜∆˙∂=;!^&?,.()%:'|{µ@!}$]/", $variable))
        {
            return true;}
        else{
            return false;}
    }    

    /* 
      Don't content character and number
    */     
    private function without_number_and_characters($variable)
    {
        if(preg_match("/[<>±˜`#*+§£∞§•¶ªºæ«…™πå∑´®†˜ç¬¥¨ˆøπ¬˚¬∆˙©ƒßå∂≈√∫µ÷≥≤˜∆˙∂=;!^&?,.%:|{µ@!}$]/", $variable))
        {
            return true;}
        else{
            return false;}
    }

    /* 
      Count character number
    */      
    private function count_character_number($Chaineposte){
        $nbrecaract = strlen($Chaineposte);
        return $nbrecaract;
    }

    /* 
      Verify if is only character and number
    */     
    public function only_number_and_character($variableverif,$nbre)
    {
        $this->verificaracteres = $this->without_number_and_characters($variableverif);
        $this->verifinbrecaractere = $this->count_character_number($variableverif);

        if($this->verificaracteres===false&&$this->verifinbrecaractere<$nbre){
            return false;
        }else
        {
            return true;
        }
    }

    /* 
      Verify if is only number
    */     
    public function only_number($variableverif,$nbre)
    {
        $this->verificaracteres = $this->without_number($variableverif);
        $this->verifinbrecaractere = $this->count_character_number($variableverif);
        
        if($this->verificaracteres===false&&$this->verifinbrecaractere<$nbre){
    
            return false;
        }else
        {
            return true;
        }
    }

    /* 
      Verify if is only character
    */    
    public function only_character($variableverif,$nbre)
    {
        $this->verificaracteres = $this->without_characters($variableverif);
        $this->verifinbrecaractere = $this->count_character_number($variableverif);
        
        if($this->verificaracteres===false&&$this->verifinbrecaractere<$nbre){
    
            return false;
        }else
        {
            return true;
        }
    }    
}