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
            ->from('elite_mapping_notes')
            ->where('fit_id = ?', $row->id)
            ->joinLeft('elite_note', 'elite_note.id = elite_mapping_notes.note_id', array('code'));
        
        $noteCodes = array();
        $result = $select->query();
        while( $noteRow = $result->fetch() )
        {
            array_push($noteCodes,$noteRow['code']);
        }
        return ',"'.implode(',',$noteCodes).'"';
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
}