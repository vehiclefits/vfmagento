<?php
class Elite_Vaflinks_Block_Cmslist extends Elite_Vaflinks_Block_List
{

    function getItems() {
        $make = new VF_Level('make');
        return $make->listInUse();
    }

    function isEnabled()
    {
        return (bool)$this->getConfig()->directory->cmsEnable;
    }

    protected function lastLevelAlreadySelected() {
        return $this->getFlexible()->getLevel() == 'make';
    }
}