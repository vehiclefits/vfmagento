<?php
if( file_exists(ELITE_PATH.'/Vafwheeladapter') )
{
    class Vaf15
    {
        function run()
        {
            include(ELITE_PATH.'/Vafwheeladapter/migrations/15_add_product_wheel_adapter_tbl.php');
        }
    }
    Vaf15::run();
}