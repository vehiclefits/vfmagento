<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
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
