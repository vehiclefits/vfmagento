<?php
interface VF_Db 
{
    function getReadAdapter();
    
    function getWriteAdapter();
}