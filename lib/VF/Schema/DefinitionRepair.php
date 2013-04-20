<?php
class VF_Schema_DefinitionRepair extends VF_Schema_Generator
{
    function repair()
    {
    	$schema = new VF_Schema(); 
        $this->levels = $schema->getLevels();

        $this->saveLeafLevels();
        
        return '';
    }
    
    protected function saveLeafLevels()
    {
        $schema = new VF_Schema();
        
        $select = $this->getReadAdapter()->select()
            ->from( 'elite_' . $schema->getLeafLevel() );
        $result = $select->query();
        
        $vehicleFinder = new VF_Vehicle_Finder( $schema );
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