<?php
if( file_exists(ELITE_PATH.'/Vaftire') )
{
    class Vaf14
    {
        function run()
        {
            include(ELITE_PATH.'/Vaftire/migrations/14_add_vehicle_tiretype.php');
        }
    }
    Vaf14::run();
}