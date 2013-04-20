<?php

class Elite_Vaflinks_Block_List extends Elite_Vaf_Block_Search {

    function __construct() {
        parent::__construct();
        $this->setTemplate('vaflinks/list.phtml');
    }

    function getDefinitions() {
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();

        if ($this->lastLevelAlreadySelected()) {
            return array();
        }

        $vehicles = array();
        $vehicleFinder = new VF_Vehicle_Finder($this->getSchema());
        foreach ($this->getItems() as $level) {
            array_push($vehicles, $vehicleFinder->findByLevel($level->getType(), $level->getId()));
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
        return (bool)Elite_Vaf_Helper_Data::getInstance()->enableDirectory();
    }

}