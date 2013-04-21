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

/** The association between a product ID and a definition */
class VF_Mapping implements VF_Configurable
{

    protected $product_id, $vehicle;
    /** @var Zend_Config */
    protected $config;

    function __construct($product_id, VF_Vehicle $vehicle)
    {
        $this->product_id = $product_id;
        $this->vehicle = $vehicle;
    }

    function getConfig()
    {
        if (!$this->config instanceof Zend_Config)
        {
            $this->config = Elite_Vaf_Helper_Data::getInstance()->getConfig();
        }
        return $this->config;
    }

    function setConfig(Zend_Config $config)
    {
        $this->config = $config;
    }

    function vehicle()
    {
        return $this->vehicle;
    }

    function save()
    {
        if (!(int) $this->product_id)
        {
            throw new Exception('Trying to insert a mapping with no product ID');
        }
        $schema = new VF_Schema;
        $schema->setConfig($this->getConfig());
        $levels = $schema->getLevels();

        $select = $this->getReadAdapter()->select()
                        ->from($schema->mappingsTable(), array('id'));
        foreach ($this->vehicle->toValueArray() as $level => $id)
        {
            $select->where($this->inflect($level) . '_id = ?', $id);
        }
        $select->where('entity_id = ?', $this->product_id);

        $id = (int) $select->query()->fetchColumn();
        if (0 !== $id)
        {
            return $id;
        }

        $columns = '';
        $values = '';
        foreach ($levels as $level)
        {
            $columns .= '`' . $this->inflect($level) . '_id`,';
            $values .= $this->inflect($this->vehicle->getLevel($level)->getId());
            $values .= ',';
        }
        $query = sprintf(
                        '
            INSERT INTO
                `'.$schema->mappingsTable().'`
            (
                ' . $columns . '
                `entity_id`
            )
            VALUES
            (
                ' . $values . '
                %d
            )
            ',
            (int) $this->product_id
        );
        $r = $this->query($query);
        return $this->getReadAdapter()->lastInsertId();
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

    function inflect($identifier)
    {
        return str_replace(' ', '_', $identifier);
    }

}