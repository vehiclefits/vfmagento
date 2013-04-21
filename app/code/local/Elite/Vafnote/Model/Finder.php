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
class Elite_Vafnote_Model_Finder
{
    /** @param integer $id find notes with a given id */
    function find( $id = 0 )
    {
        $sql = sprintf("SELECT `elite_note`.* FROM elite_note WHERE `id` = %s LIMIT 1",$this->getReadAdapter()->quote($id));
        $result = $this->query( $sql );
        $note = $result->fetchObject();
        return $note;
    }
    
    /** @param string $message find notes with an exact match for this message */
    function findByMessage( $message )
    {
        $sql = sprintf("SELECT `elite_note`.* FROM elite_note WHERE `message` = %s LIMIT 1",$this->getReadAdapter()->quote($message));
        $result = $this->query( $sql );
        $note = $result->fetchObject();
        return $note;
    }
    
    /** @param string $code alpha numeric note code */
    function findByCode( $code )
    {
        $sql = sprintf("SELECT `elite_note`.* FROM elite_note WHERE `code` = %s LIMIT 1",$this->getReadAdapter()->quote($code));
        $result = $this->query( $sql );
        $note = $result->fetchObject();
        return $note;
    }
    
    /**
    * @param integer $mapping_id the mapping/fitment id to get an array of notes for
    * @return array of notes (stdClass objects)
    */
    function getNotes( $mapping_id = 0 )
    {
        if(!$mapping_id)
        {
            return array();
        }
        $notes = $this->getAllNotes($mapping_id);
        return $notes;
    }
    
    function getAllNotes($mapping_id=0)
    {
        $sql = "SELECT * FROM elite_note";
        
        if( $mapping_id )
        {
            $sql .=  sprintf( " INNER JOIN elite_mapping_notes on elite_mapping_notes.note_id = elite_note.id AND elite_mapping_notes.fit_id = %d", $mapping_id );
        }
        $result = $this->query( $sql );

        $return = array();
        while( $note = $result->fetchObject() )
        {
            array_push( $return, $note );
        }
        return $return;
    }
    
    /**
    * @param mixed $code alpha numeric note code, pass null to auto-generate
    * @param mixed $message note message
    * @return note id (last insert id)
    */
    function insert( $code=null, $message )
    {
        $message = trim($message);
        if(is_null($code))
        {
            $note = $this->findByMessage($message);
            if($note)
            {
                return $note->id;
            }
            else
            {
                $code = $this->uniqueCode();
            }
        }
        $sql = sprintf(
        	"INSERT INTO `elite_note` (`code`,`message`) VALUES ( %s, %s ) ON DUPLICATE KEY UPDATE `message` = VALUES(message)",
        	$this->getReadAdapter()->quote($code),
        	$this->getReadAdapter()->quote($message)
        );
        
        $this->query($sql);
        return $this->getReadAdapter()->lastInsertId();
    }
    
    /** Generates a unique code along these formats "code-1", "code-2" to be used for inserting a new note */
    function uniqueCode()
    {
        $i = 1;
        $codeFormat = 'code-%d';
        do
        {
            $code = sprintf($codeFormat,$i);
            $note = $this->findByCode($code);
            if(!$note)
            {
                return $code;
            }
            $i++;
        }
        while(true);
    }
    
    /**
    * @param integer $mapping_id the mapping/fitment id this note is for
    * @param string $note_code the alpha-numeric note code
    */
    function insertNoteRelationship( $mapping_id, $note_code )
    {
        $sql = sprintf(
            "
            REPLACE INTO `elite_mapping_notes`
                ( fit_id, note_id )
            VALUES
                ( %d, %s )
            ",
            $mapping_id,
            $this->getReadAdapter()->quote($note_code)
        );
        $this->query($sql);   
    }
    
    /**
    * @param integer $id the primary ID for the note
    * @param string $message the new message
    */
    function update( $id, $message )
    {
        $sql = sprintf(
        	"UPDATE `elite_note` set `message` = %s WHERE `id` = %s",
        	$this->getReadAdapter()->quote($message),
        	$this->getReadAdapter()->quote($id)
        );
        $this->query($sql);
    }
    
    /** @param integer $id the primary ID for the note */
    function delete( $id )
    {
        $sql = sprintf( "DELETE FROM `elite_note` WHERE `id` = %s", $this->getReadAdapter()->quote($id) );
        $this->query($sql);
    }
    
    /** @return Zend_Db_Statement_Interface */
    protected function query( $sql )
    {
        return $this->getReadAdapter()->query( $sql );
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
}
