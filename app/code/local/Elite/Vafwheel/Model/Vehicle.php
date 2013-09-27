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
class Elite_Vafwheel_Model_Vehicle
{
    /** @var VF_Vehicle */
    protected $wrappedVehicle;
    
    function __construct(VF_Vehicle $vehicle )
    {
        $this->wrappedVehicle = $vehicle;
    }
    
    function __call($methodName,$arguments)
    {
        $method = array($this->wrappedVehicle,$methodName);
        return call_user_func_array( $method, $arguments );
    }
    
    function addBoltPattern( Elite_Vafwheel_Model_BoltPattern_Single $boltPattern )
    {
        $this->query( sprintf(
            "REPLACE INTO `elite_definition_wheel` ( `leaf_id`, `lug_count`, `bolt_distance`, `offset` ) VALUES ( %d, %d, %s, %s )",
            $this->getId(),
            (int)$boltPattern->getLugCount(),
            (float)$boltPattern->getDistance(),
            (float)$boltPattern->getOffset()
        ));
    }
    
    /** @return Elite_Vafwheel_Model_BoltPattern_Single */
    function boltPattern()
    {
        $r = $this->query( sprintf(
            "
            SELECT lug_count, bolt_distance, offset
            FROM elite_definition_wheel
            WHERE leaf_id = %d
            ",
            (int)$this->wrappedVehicle->getId()
        ));
        return $r->fetchObject();
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
