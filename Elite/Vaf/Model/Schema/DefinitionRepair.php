<?php
class Elite_Vaf_Model_Schema_DefinitionRepair extends Ne8Vehicle_Schema_Generator
{
    function repair()
    {
    	$schema = new Elite_Vaf_Model_Schema(); 
        $this->levels = $schema->getLevels();

        $this->saveLeafLevels();
        
        return '';
    }
    
    protected function saveLeafLevels()
    {
        $schema = new Elite_Vaf_Model_Schema();
        
        $select = $this->getReadAdapter()->select()
            ->from( 'elite_' . $schema->getLeafLevel() );
        $result = $select->query();
        
        $vehicleFinder = new Elite_Vaf_Model_Vehicle_Finder( $schema );
        foreach( $result->fetchAll(Zend_Db::FETCH_OBJ) as $row )
        {
            $vehicle = $vehicleFinder->findByLeaf( $row->id );
            $bind = array();
            foreach( $schema->getLevels() as $level )
            {
                $bind[ $level.'_id' ] = $vehicle->getLevel( $level )->getId();
            }
            try
            {
                $this->getReadAdapter()->insert( 'elite_definition', $bind );
            }
            catch( Exception $e )
            {
            }
            
        }
    }
}