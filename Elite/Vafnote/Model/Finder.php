<?php
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
    * @param integer $Fitment_id the Fitment/fitment id to get an array of notes for
    * @return array of notes (stdClass objects)
    */
    function getNotes( $Fitment_id = 0 )
    {
        $sql = "SELECT * FROM elite_note";
        
        if( $Fitment_id )
        {
            $sql .=  sprintf( " INNER JOIN elite_Fitment_notes on elite_Fitment_notes.note_id = elite_note.code AND elite_Fitment_notes.fit_id = %d", $Fitment_id );
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
    * @param integer $Fitment_id the Fitment/fitment id this note is for
    * @param string $note_code the alpha-numeric note code
    */
    function insertNoteRelationship( $Fitment_id, $note_code )
    {
        $sql = sprintf(
            "
            REPLACE INTO `elite_Fitment_notes`
                ( fit_id, note_id )
            VALUES
                ( %d, %s )
            ",
            $Fitment_id,
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
