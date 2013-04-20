<?php
if( file_exists(ELITE_PATH.'/Vaftire') )
{
    class Vaf13
    {
        function run()
        {
            include(ELITE_PATH.'/Vaftire/migrations/13_addtiretype.php');
        }
    }
    Vaf13::run();
}