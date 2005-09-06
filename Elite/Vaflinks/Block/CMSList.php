<?php
class Elite_Vaflinks_Block_CMSList extends Elite_Vaflinks_Block_List
{

    function vafUrl( Elite_Vaf_Model_Vehicle $vehicle )
    {
        $schema = new Elite_Vaf_Model_Schema;
        $root = $schema->getRootLevel();
        $params = http_build_query(array($root => $vehicle->getValue($root)));
        
        return '/vaflinks/cms?' . $params;
    }

    function isEnabled()
    {
        return (bool)$this->getConfig()->directory->cmsEnable;
    }

    protected function lastLevelAlreadySelected() {
        return $this->getFlexible()->getLevel() == $this->getSchema()->getRootLevel();
    }
}