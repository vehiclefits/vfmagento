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
class Elite_Vafwheel_Model_Finder
{
    function listLugCounts()
    {
        $select = $this->getReadAdapter()->select()
            ->from('elite_product_wheel','distinct(lug_count) lug_count');
        $result = $select->query();
        $return = array();
        while($row = $result->fetch())
        {
            $return[ $row['lug_count'] ] = $row['lug_count'];
        }
        return $return;
    }
    
    function listSpread()
    {
        $select = $this->getReadAdapter()->select()
            ->from('elite_product_wheel','distinct(bolt_distance) bolt_distance');
        $result = $select->query();
        $return = array();
        while($row = $result->fetch())
        {
            $return[ (string)$row['bolt_distance'] ] = $row['bolt_distance'];
        }
        return $return;
    }
    
    function getProductIds( Elite_Vafwheel_Model_BoltPattern_Single $bolt)
    {
        $select = $this->getReadAdapter()->select()
            ->from('elite_product_wheel','distinct(entity_id) entity_id')
            ->where('lug_count = ?', $bolt->getLugCount() )
            ->where('bolt_distance = ?', $bolt->getDistance() );
        $result = $select->query();
        $return = array();
        while($row = $result->fetch())
        {
            array_push($return,$row['entity_id']);
        }
        return $return;
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
}