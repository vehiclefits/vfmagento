<?php
if( file_exists(ELITE_PATH.'/Vaftire') )
{
    class Vaf9
    {
        function addTireSpecTbl()
        {
            include(ELITE_PATH.'/Vaftire/migrations/9_add_product_tire_tbl.php');
        }
    }
    Vaf9::addTireSpecTbl();
}