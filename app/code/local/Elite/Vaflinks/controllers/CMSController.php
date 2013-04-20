<?php
/**
* Vehicle Fits Free Edition - Copyright (c) 2008-2010 by Vehicle Fits, LLC
* PROFESSIONAL IDENTIFICATION:
* "www.vehiclefits.com"
* PROMOTIONAL SLOGAN FOR AUTHOR'S PROFESSIONAL PRACTICE:
* "Automotive Ecommerce Provided By Vehicle Fits llc"
*
* All Rights Reserved
* VEHICLE FITS ATTRIBUTION ASSURANCE LICENSE (adapted from the original OSI license)
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the conditions in license.txt are met
*/
class Elite_Vaflinks_CMSController extends Mage_Core_Controller_Front_Action
{

    function indexAction()
    {
        $this->loadLayout();

        $this->block = $this->getLayout()->createBlock('vaflinks/cms', 'vaflinks_cms');
        
        $this->_addContent($this->block);
        $this->renderLayout();
    }

    protected function _addContent(Mage_Core_Block_Abstract $block)
    {
        $this->getLayout()->getBlock('content')->append($block);
        return $this;
    }
}