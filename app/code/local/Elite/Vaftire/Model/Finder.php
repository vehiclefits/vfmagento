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
class Elite_Vaftire_Model_Finder
{
    function sectionWidths()
    {
        $select = $this->getReadAdapter()->select()
            ->from('elite_product_tire','distinct(section_width) section_width')
            ->order('section_width');
        $result = $select->query();
        $return = array();
        while($row = $result->fetch())
        {
            $return[ $row['section_width'] ] = $row['section_width'];
        }
        return $return;
    }
    
    function aspectRatios()
    {
        $select = $this->getReadAdapter()->select()
            ->from('elite_product_tire','distinct(aspect_ratio) aspect_ratio')
            ->order('aspect_ratio');
        $result = $select->query();
        $return = array();
        while($row = $result->fetch())
        {
            $return[ $row['aspect_ratio'] ] = $row['aspect_ratio'];
        }
        return $return;
    }
    
    function diameters()
    {
        $select = $this->getReadAdapter()->select()
            ->from('elite_product_tire','distinct(diameter) diameter')
            ->order('diameter');
        $result = $select->query();
        $return = array();
        while($row = $result->fetch())
        {
            $return[ $row['diameter'] ] = $row['diameter'];
        }
        return $return;
    }
    
    function productIds( Elite_Vaftire_Model_TireSize $tireSize, $tireType = null )
    {
        $select = $this->getReadAdapter()->select()
            ->from('elite_product_tire','distinct(entity_id) entity_id')
            ->where('section_width = ?', $tireSize->sectionWidth() )
            ->where('aspect_ratio = ?', $tireSize->aspectRatio() )
            ->where('diameter = ?', $tireSize->diameter() );
        if(!is_null($tireType))
        {
			$select->where('tire_type = ?',$tireType);
        }
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