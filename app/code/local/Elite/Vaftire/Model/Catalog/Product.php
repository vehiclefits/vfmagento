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

class Elite_Vaftire_Model_Catalog_Product
{

    /** @var Elite_Vaf_Model_Catalog_Product */
    protected $wrappedProduct;

    const SUMMER_ALL = 1;
    const WINTER = 2;

    function __construct(Elite_Vaf_Model_Catalog_Product $productToWrap)
    {
        $this->wrappedProduct = $productToWrap;
    }

    /** @param mixed boolean false for none, or Elite_Vaftire_Model_TireSize */
    function setTireSize($tireSize)
    {
        if (false === $tireSize) {
            $sql = sprintf("DELETE FROM `elite_product_tire` WHERE `entity_id` = %d", $this->getId());
            return $this->query($sql);
        }
        $sql = sprintf(
            "INSERT INTO `elite_product_tire` ( `entity_id`, `section_width`, `aspect_ratio`, `diameter` ) VALUES ( %d, %d, %d, %d )
            ON DUPLICATE KEY UPDATE `section_width` = VALUES(`section_width`), `aspect_ratio` = VALUES(`aspect_ratio`), `diameter` = VALUES(`diameter`) ",
            $this->getId(),
            (int)$tireSize->sectionWidth(),
            (int)$tireSize->aspectRatio(),
            (int)$tireSize->diameter()
        );
        $this->query($sql);
        $this->doBindTireVehicles($tireSize);
    }

    function doBindTireVehicles($tireSize)
    {
        if (!$this->getId() || !$tireSize->sectionWidth() || !$tireSize->diameter() || !$tireSize->aspectRatio()) {
            return;
        }
        $select = $this->getReadAdapter()->select()
            ->from('elite_vehicle_tire')
            ->where('section_width = ?', $tireSize->sectionWidth())
            ->where('diameter = ?', $tireSize->diameter())
            ->where('aspect_ratio = ?', $tireSize->aspectRatio());

        $result = $select->query();
        foreach ($result->fetchAll() as $vehicleRow) {
            $vehicle = $this->vehicle($vehicleRow['leaf_id']);
            $this->addVafFit($vehicle->toValueArray());
        }
    }

    function vehicle($vehicleID)
    {
        $vehicleFinder = new VF_Vehicle_Finder(new VF_Schema());
        return $vehicleFinder->findById($vehicleID);
    }

    /** @return Elite_Vaftire_Model_TireSize */
    function getTireSize()
    {
        if (!$this->getId()) {
            return false;
        }
        $select = $this->getReadAdapter()->select()
            ->from('elite_product_tire')
            ->where('entity_id=?', $this->getId());

        $result = $select->query();
        $row = $result->fetchObject();
        if (!$row || (!$row->section_width && !$row->aspect_ratio && !$row->diameter)) {
            return false;
        }

        $tireSize = new Elite_Vaftire_Model_TireSize($row->section_width, $row->aspect_ratio, $row->diameter);
        return $tireSize;
    }

    function tireType()
    {
        if (!$this->getId()) {
            return false;
        }
        $select = $this->getReadAdapter()->select()
            ->from('elite_product_tire')
            ->where('entity_id=?', $this->getId());
        $result = $select->query();
        $row = $result->fetchObject();
        if (!$row || !$row->tire_type) {
            return false;
        }
        return $row->tire_type;
    }

    function setTireType($tireType)
    {
        $sql = sprintf(
            "INSERT INTO `elite_product_tire` ( `entity_id`, `tire_type` ) VALUES ( %d, %d )
            ON DUPLICATE KEY UPDATE `tire_type` = VALUES(`tire_type`)",
            $this->getId(),
            (int)$tireType
        );
        $this->query($sql);
    }

    function __call($methodName, $arguments)
    {
        $method = array($this->wrappedProduct, $methodName);
        return call_user_func_array($method, $arguments);
    }

    /** @return Zend_Db_Statement_Interface */
    protected function query($sql)
    {
        return $this->getReadAdapter()->query($sql);
    }

    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }

}