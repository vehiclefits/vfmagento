<?php
interface VafVehicle_Db 
{
    function getReadAdapter();
    
    function getWriteAdapter();
}