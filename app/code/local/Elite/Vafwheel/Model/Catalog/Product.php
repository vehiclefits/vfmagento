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
class Elite_Vafwheel_Model_Catalog_Product
{
    /** @var Elite_Vaf_Model_Catalog_Product */
    protected $wrappedProduct;
    
    function __construct(Elite_Vaf_Model_Catalog_Product $productToWrap )
    {
        $this->wrappedProduct = $productToWrap;
    }
    
    function addBoltPattern( Elite_Vafwheel_Model_BoltPattern $boltPattern )
    {
        $sql = sprintf(
            "REPLACE INTO `elite_product_wheel` ( `entity_id`, `lug_count`, `bolt_distance`, `offset` ) VALUES ( %d, %d, %s, %s )",
            $this->getId(),
            (int)$boltPattern->getLugCount(),
            (float)$boltPattern->getDistance(),
            (float)$boltPattern->getOffset()
        );
        $this->query($sql);
        $this->insertMappings($boltPattern);
    }
    
    function getBoltPatterns()
    {
	if(!$this->getId())
	{
	    return array();
	}
        $select = $this->getReadAdapter()->select()
            ->from('elite_product_wheel')
            ->where('entity_id=?',$this->getId());
        $result = $select->query();
            
        $return = array();
        while( $row = $result->fetchObject() )
        {
            $bolt = Elite_Vafwheel_Model_BoltPattern::create($row->lug_count.'x'.$row->bolt_distance, $row->offset);
            array_push($return,$bolt);
        }
        $result->closeCursor();
        
        return $return;
    }
    
    function removeBoltPatterns()
    {
        $this->getReadAdapter()->query(sprintf("DELETE FROM `elite_product_wheel` WHERE `entity_id` = %d",$this->getId()));
    }
    
    function insertMappings( Elite_Vafwheel_Model_BoltPattern $boltPattern )
    {
        if( $boltPattern->getOffset() )
        {
            $q = sprintf(
                "
                SELECT DISTINCT(`leaf_id`) as leaf_id
                FROM `elite_definition_wheel`
                WHERE `bolt_distance` = %s
                AND `lug_count` = %d
                AND `offset` >= %s
                AND `offset` <= %s
                ",
                (float)$boltPattern->getDistance(),
                (float)$boltPattern->getLugCount(),
                (float)$boltPattern->offsetMin(),
                (float)$boltPattern->offsetMax()
            );
        }
        else
        {
            $q = sprintf(
                "
                SELECT DISTINCT(`leaf_id`) as leaf_id
                FROM `elite_definition_wheel`
                WHERE `bolt_distance` = %s
                AND `lug_count` = %d
                ",
                (float)$boltPattern->getDistance(),
                (float)$boltPattern->getLugCount()
            );
        }
        
        $result = $this->query( $q );
        
        $years = array();
        
        $rows = $result->fetchAll( Zend_Db::FETCH_OBJ );
        foreach($rows as $row)
        {
            $vehicle = $this->definition( $row->leaf_id );
            $this->insertMapping($vehicle);
        }
    }
    
    function definition($vehicle_id)
    {
        $vehicleFinder = new VF_Vehicle_Finder( new VF_Schema() );
        return $vehicleFinder->findById($vehicle_id);
    }
    
    function __call($methodName,$arguments)
    {
        $method = array($this->wrappedProduct,$methodName);
        return call_user_func_array( $method, $arguments );
    }
    
    /** @return Zend_Db_Statement_Interface */
    protected function query( $sql )
    {
        return $this->getReadAdapter()->query( $sql );
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Singleton::getInstance()->getReadAdapter();
    }
}