<?php

namespace bin\epaphrodite\others;

use bin\epaphrodite\auth\session_auth;

class visite_compter{


    /**
     * ***************************************************************************************************
     * Construct function
     * @return mixed
    */ 
    function __construct()
    {
        $this->session = new session_auth();
    }  
    
    /**
     * ***************************************************************************************************
     * Files function of visit and visitor
     * @return string
    */     
    public function file_countor_de_visite_day(){ return _DIR_VISITOR_ . 'countorvisite'.'-'. date("Y-m-d"); }
    public function file_countor_de_visite_month(){ return _DIR_VISITOR_ . 'countorvisite'.'-'. date("Y") . '-' .date("*") .'-'. '*'; }
    public function file_countor_de_visite_year(){ return _DIR_VISITOR_ . 'countorvisite'.'-'. date("Y") . '-' .date("*") .'-'. '*';}
    public function file_countor_visitor_day_of_website(){ return _DIR_VISITOR_ . 'visiteur_du_site'.'-'. date("Y-m-d"); }
    public function file_countor_visitor_month_of_website(){ return _DIR_VISITOR_ . 'visiteur_du_site'.'-'. date("Y") . '-' . date("*") .'-'. '*'; }
    public function file_countor_visitor_year_of_website(){ return _DIR_VISITOR_ . 'visiteur_du_site'.'-'. date("Y") . '-' .date("*") .'-'. '*';}


    /**
     * ***************************************************************************************************
     * Add views on file
     * @return string
    */      
    public function add_visit_comptor_view(){

        /** Increment visit countor */
        $this->increment_visit_countor($this->file_countor_de_visite_day());

        /** Increment visitor countor */
        $this->increment_visitor_countor($this->file_countor_visitor_day_of_website());

    }

    /**
     * ***************************************************************************************************
     * Increment function visit files containt
     * @param string|null
     * @return int
    */      
    private function increment_visit_countor( ?string $file_of_comptor=NULL ){
        
        $compteur = 1;
        
        if(file_exists($file_of_comptor))
        {

            $compteur = (int)file_get_contents($file_of_comptor);
            $compteur++;

        }
       
        file_put_contents( $file_of_comptor , $compteur );

    }

    /**
     * ***************************************************************************************************
     * Increment function visitor files containt
     * @return string
    */     
    private function increment_visitor_countor($file_of_comptor){


        if($this->session->visiteur()===NULL)
        {

            $compteur = 1;
            if(file_exists($file_of_comptor))
            {

                $compteur = (int)file_get_contents($file_of_comptor);
                $compteur++;
    
            }

            $_SESSION['visiter']='visit';

            file_put_contents( $file_of_comptor , $compteur );

        }      

        
    }    


    /**
     * ***************************************************************************************************
     * Get all visit views per day
     * @return int
    */     
    public function all_visit_view_per_day()
    {
       
        $file_of_comptor = glob($this->file_countor_de_visite_day());
        $totalvisitejour = 0;
        foreach ($file_of_comptor as $file_of_comptor)
        {
            $totalvisitejour += (int)file_get_contents($file_of_comptor);
        }

        return $totalvisitejour;

    }      

    /**
     * ***************************************************************************************************
     * Get all visit views per month
     * @return int
    */ 
    public function all_visit_view_per_month(){

        $file_of_comptor = glob($this->file_countor_de_visite_month());
        $totalvisite = 0;
        foreach ($file_of_comptor as $file_of_comptor)
        {
            $totalvisite += (int)file_get_contents($file_of_comptor);
        }
        
        return $totalvisite;
    }

    /**
     * ***************************************************************************************************
     * Get all visit views per year
     * @return int
    */     
    public function all_visit_view_per_years()
    {

        $file_of_comptortotol = glob($this->file_countor_de_visite_year());
        $totalvisitefichier = 0;
        foreach ($file_of_comptortotol as $file_of_comptortotol)
        {
            $totalvisitefichier += (int)file_get_contents($file_of_comptortotol);
        }

        return $totalvisitefichier;

    }


    /**
     * ***************************************************************************************************
     * Get all visitor views per day
     * @return int
    */     
    public function all_visitor_view_per_day()
    {
       
        $file_of_comptor = glob($this->file_countor_visitor_day_of_website());
        $totalvisitejour = 0;
        foreach ($file_of_comptor as $file_of_comptor)
        {
            $totalvisitejour += (int)file_get_contents($file_of_comptor);
        }

        return $totalvisitejour;

    }  
    
    /**
     * ***************************************************************************************************
     * Get all visitor views per month
     * @return int
    */ 
    public function all_visitor_view_per_month(){

        $file_of_comptor = glob($this->file_countor_visitor_month_of_website());
        $totalvisite = 0;
        foreach ($file_of_comptor as $file_of_comptor)
        {
            $totalvisite += (int)file_get_contents($file_of_comptor);
        }
        
        return $totalvisite;
    }

    /**
     * ***************************************************************************************************
     * Get all visitor views per year
     * @return int
    */     
    public function all_visitor_view_per_years()
    {

        $file_of_comptortotol = glob($this->file_countor_visitor_year_of_website());
        $totalvisitefichier = 0;
        foreach ($file_of_comptortotol as $file_of_comptortotol)
        {
            $totalvisitefichier += (int)file_get_contents($file_of_comptortotol);
        }

        return $totalvisitefichier;

    }    
 

}