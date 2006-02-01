<?php
/**
* Callback for a product fitment row being imported. This callback is expected to extract fitment information from the fitment row, and handle its responsibilities of
* inserting/updating fitments & their notes respectively
* 
* Side effects: creates a fitment note, associates them to products
*/
class Elite_Vafnote_Observer_Importer_Mappings
{
    /** @var array $fields for the current row */
    protected $fields;
    
    /** @var array $row the row being imported */
    protected $row;
    
    /**
    * @param array $fields for the current row
    * @param array $row the row being imported
    */
    function doImportRow( $fields, $row )
    {
        $this->fields = $fields;
        $this->row = $row;
        $this->importFitmentNotes();
    }
    
    function importFitmentNotes()
    {
         $this->importFitmentNotesByCode();
         $this->importFitmentNotesByMessage();
    }
    
    function importFitmentNotesByCode()
    {
        if( !$this->hasNotesColumn() )
        {
            return;
        }
        
        $notes = $this->getRowValue('notes');
        $notes = explode( ',', $notes );
        foreach( $notes as $noteCode )
        {
            $note = $this->noteFinder()->findByCode($noteCode);
            if(!$note) continue;
            $this->noteFinder()->insertNoteRelationship( $this->row['mapping_id'], $note->id );
        }
    }
    
    function importFitmentNotesByMessage()
    {
        if( !$this->hasNoteMessageColumn() )
        {
            return;
        }
        
        $message = $this->getRowValue('note_message');
        if(!$message)
        {
            return;
        }
        $noteId = $this->noteFinder()->insert(null,$message);
        $note = $this->noteFinder()->find($noteId);
        $this->noteFinder()->insertNoteRelationship($this->row['mapping_id'], $note->id );
    }
    
    function hasNotesColumn()
    {
        return isset( $this->fields['notes'] );
    }
    
    function hasNoteMessageColumn()
    {
        return isset( $this->fields['note_message'] );
    }
    
    function getRowValue($field)
    {
        return isset($this->row[$field]) ? $this->row[$field] : false;
    }
    
    protected function query( $sql )
    {
        return $this->getReadAdapter()->query( $sql );
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
    
    function noteFinder()
    {
        return new Elite_Vafnote_Model_Finder();
    }
}
