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

class Elite_Vafsitemap_Model_Sitemap_Vehicle extends VF_Import_Abstract
{

    protected $config;
    protected $schema;

    function __construct($config)
    {
        $this->schema = new VF_Schema;
        $this->config = $config;
    }

    /** @todo move/rename this to definition finder -> find all in use() method */
    function getDefinitions($perPage = false, $offset = false, $productId = null)
    {
        $return = array();
        $vehicleFinder = new VF_Vehicle_Finder($this->getSchema());
        $vehicles = $this->doGetDefinitions($perPage, $offset, $productId);
        foreach ($vehicles as $vehicleStdClass) {
            $vehicle = $vehicleFinder->findOneByLevelIds($vehicleStdClass, VF_Vehicle_Finder::INCLUDE_PARTIALS);
            array_push($return, $vehicle);
        }
        return $return;
    }

    function doGetDefinitions($perPage, $offset, $productId = null)
    {
        $rewriteLevels = $this->getSchema()->getRewriteLevels();

        $db = $this->getReadAdapter();

        $cols = array();
        foreach ($this->getSchema()->getRewriteLevels() as $col) {
            $cols[] = $col . '_id';
        }
        $select = $db->select()
            ->from($this->getSchema()->mappingsTable(), $cols);
        foreach ($rewriteLevels as $level) {
            $select->group($level . '_id');
        }

        if (!is_null($productId)) {
            $select->where('entity_id = ?', $productId);
        }

        if ($perPage || $offset) {
            $select->limit($perPage, $offset);
        }

        $result = $select->query(Zend_Db::FETCH_ASSOC);
        $return = array();
        while ($row = $result->fetch()) {
            array_push($return, $row);
        }

        return $return;
    }

    /** @return integer total # of definitions in the sitemap */
    function vehicleCount()
    {
        $col = 'count(distinct(CONCAT(';
        $colParams = array();
        foreach ($this->getSchema()->getRewriteLevels() as $level) {
            $colParams[] = $level . '_id';
        }
        $col .= implode(',\'/\',', $colParams);
        $col .= ')))';

        $select = $this->getReadAdapter()->select()
            ->from($this->getSchema()->mappingsTable(), array($col));

        $result = $select->query();
        $count = $result->fetchColumn();
        return $count;
    }

    function getSchema()
    {
        $schema = new VF_Schema();
        $schema->setConfig($this->config);
        return $schema;
    }

}