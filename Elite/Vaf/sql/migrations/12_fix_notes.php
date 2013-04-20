<?php
if( file_exists(ELITE_PATH.'/Vafnote') )
{
    class Vaf12
    {
        function fix()
        {
            include(ELITE_PATH.'/Vafnote/12_fix_notes.php');
        }
    }
    Vaf12::fix();
}