<?php
class Elite_Vaflinks_Block_CMS extends Elite_Vaf_Block_Abstract
{
    function __construct() {
        parent::__construct();
        $this->setTemplate('vaflinks/cms.phtml');
    }

    function isEnabled() {
        return (bool)Elite_Vaf_Helper_Data::getInstance()->getConfig()->directory->cmsEnable;
    }
}