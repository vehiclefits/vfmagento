<?php
abstract class Elite_Vafnote_Observer_Exporter_Mappings
{    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
}