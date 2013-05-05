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
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Elite_Vafpaint_Model_Paint_Mapper
{
    /**
    * Find the paint code for a fit
    * 
    * @param mixed $year_id
    * @return array of Elite_Vaf_Model_Paint
    */
    function findByVehicleId( $vehicle_id )
    {
        $select = $this->getReadAdapter()->select()
        	->from( 'elite_mapping_paint' )
        	->where( 'mapping_id = ?', (int)$vehicle_id );
        $result = $select->query();
        $return = array();
        while( $code = $result->fetch( Zend_Db::FETCH_OBJ ) )
        {
            array_push( $return, new Elite_Vafpaint_Model_Paint( $code->code, $code->name, $code->color, $code->id ) );
        }
        return $return;
    }
    
    /**
    * Find the paint code for a paint_id
    * 
    * @param mixed $paint_id
    * @return Elite_Vaf_Model_Paint
    */
    function find( $paint_id )
    {
        $select = $this->getReadAdapter()->select()
            ->from( 'elite_mapping_paint' )
        	->where( 'id = ?', (int)$paint_id );
        $result = $select->query();
        $code = $result->fetch( Zend_Db::FETCH_OBJ );
        $paint = new Elite_Vafpaint_Model_Paint( $code->code, $code->name, $code->color, $code->id );
        return $paint;
    }
    
    /** @return Zend_Db_Statement_Interface */
    protected function query( $sql )
    {
        return $this->getReadAdapter()->query( $sql );
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return VF_Singleton::getInstance()->getReadAdapter();
    }

}