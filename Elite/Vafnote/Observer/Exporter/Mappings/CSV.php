<?php
class Elite_Vafnote_Observer_Exporter_Mappings_CSV extends Elite_Vafnote_Observer_Exporter_Mappings
{
    function doCols()
    {
        return ',notes';
    }
    
    function doRow($row)
    {
        $select = $this->getReadAdapter()->select()
            ->from('elite_mapping_notes',array('note_id'))
            ->where('fit_id = ?', $row->id);
        $noteIds = array();
        $result = $select->query();
        while( $noteRow = $result->fetch() )
        {
            array_push($noteIds,$noteRow['note_id']);
        }
        return ',"'.implode(',',$noteIds).'"';
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
}