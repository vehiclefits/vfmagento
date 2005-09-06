<?php
class Elite_Vaflinks_Block_CMS extends Elite_Vaf_Block_Abstract
{
    function __construct() {
        parent::__construct();
        $this->setTemplate('vaflinks/cms.phtml');
    }
}