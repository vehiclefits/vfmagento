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
class Elite_Vafrelated_Model_Catalog_Product
{
    /** @var Elite_Vaf_Model_Catalog_Product */
    protected $wrappedProduct;

    function __construct(Elite_Vaf_Model_Catalog_Product $productToWrap)
    {
        $this->wrappedProduct = $productToWrap;
    }

    function relatedProducts($vehicle)
    {
        $select = $this->getReadAdapter()->select()
            ->from($this->wrappedProduct->getSchema()->mappingsTable(), array('entity_id'))
            ->where('entity_id != ' . $this->getId())
            ->where('related = 1');
        foreach ($vehicle->toValueArray() as $level => $id) {
            $select->where($level . '_id = ?', $id);
        }
        $productIds = array();
        foreach ($select->query()->fetchAll() as $row) {
            $productIds[] = $row['entity_id'];
        }

        return $productIds;
    }

    function showInRelated()
    {
        if (!$this->getId()) {
            return false;
        }
        $select = $this->getReadAdapter()->select()
            ->from($this->wrappedProduct->getSchema()->mappingsTable(), array('related'))
            ->where('entity_id = ' . $this->getId());

        return (bool)$select->query()->fetchColumn();
    }

    function setShowInRelated($value)
    {
        $select = $this->getReadAdapter()->select()
            ->from($this->wrappedProduct->getSchema()->mappingsTable(), array('count(*)'))
            ->where('entity_id = ' . $this->getId());
        if (0 == $select->query()->fetchColumn() && $value) {
            $this->query(
                sprintf(
                    "
                    REPLACE INTO
                    `" . $this->wrappedProduct->getSchema()->mappingsTable() . "`
                    (
                    `related`,
                    `entity_id`
                    )
                    VALUES
                    (
                    %d,
                    %d
                    )
                    ",
                    1,
                    (int)$this->getId()
                )
            );
        }
        $this->query('UPDATE ' . $this->wrappedProduct->getSchema()->mappingsTable() . ' set related = ' . (int)$value . ' where entity_id = ' . (int)$this->getId());
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
        return VF_Singleton::getInstance()->getReadAdapter();
    }
}