<?php
if( file_exists(ELITE_PATH.'/Vafwheel') )
{
    class Vaf11
    {
        function addWheelSpecTbl()
        {
            include(ELITE_PATH.'/Vafwheel/migrations/11_add_product_wheel_tbl.php');
        }
    }
    Vaf11::addWheelSpecTbl();
}