<?php

namespace bin\epaphrodite\transit_folder;

class python_transit_file
{


    function test()
    {
        $return='test';

        system( 'sudo python /bin/epaphrodite/python/python_scripts.py bloc'.$return );

         return $return;
    }

}