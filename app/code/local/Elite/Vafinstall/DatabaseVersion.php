<?php
class Elite_Vafinstall_DatabaseVersion
{
    function version()
    {
        $result = $this->db()->query('select `version` from `elite_version` LIMIT 1' );
        return $result->fetch();
    }
    
    function db()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
}