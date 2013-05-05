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

class Elite_Vaflinks_Block_List extends Elite_Vaf_Block_Search {

    function __construct() {
        parent::__construct();
        $this->setTemplate( 'vf/vaflinks/list.phtml');
    }

    function getDefinitions() {
        VF_Singleton::getInstance()->storeFitInSession();

        if ($this->lastLevelAlreadySelected()) {
            return array();
        }

        $vehicles = array();
        $vehicleFinder = new VF_Vehicle_Finder($this->getSchema());
        foreach ($this->getItems() as $level) {
            $vehicle = $vehicleFinder->findByLevel($level->getType(), $level->getId());
            array_push($vehicles, $vehicle);
        }
        return $vehicles;
    }

    function lastLevelAlreadySelected() {
        return $this->getFlexible()->getLevel() == $this->getSchema()->getLeafLevel();
    }

    function getItems() {
        $level = $this->getListLevel();
        $items = $this->listEntities($level);
        return $items;
    }

    function getListLevel() {
        $flexible = $this->getFlexible();
        if (!$flexible->getLevel()) {
            return $this->getSchema()->getRootLevel();
        }

        $level = $flexible->getLevel();
        $level = $this->getSchema()->getNextLevel($level);
        if ($level) {
            return $level;
        }
        return $this->getSchema()->getRootLevel();
    }

    function vafUrl(VF_Vehicle $vehicle) {
        $params = http_build_query($vehicle->toValueArray());
        if ($vehicle->getLeafValue()) {
            if ('/' == $this->getRequest()->getBasePath()) {
                return '/vaf/product/list?' . $params;
            }
            return $this->getRequest()->getBasePath() . '/vaf/product/list?' . $params;
        }
        return '?' . $params;
    }

    function getFlexible() {
        return new VF_FlexibleSearch($this->getSchema(), $this->getRequest());
    }

    function getSchema() {
        return new VF_Schema;
    }

    function _toHtml() {
        if (!$this->isEnabled()) {
            return;
        }

        return parent::_toHtml();
    }
    
    function isEnabled() {
        return (bool)VF_Singleton::getInstance()->enableDirectory();
    }

}