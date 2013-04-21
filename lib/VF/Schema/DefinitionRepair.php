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