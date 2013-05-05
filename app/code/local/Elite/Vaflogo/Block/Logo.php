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

class Elite_Vaflogo_Block_Logo extends Mage_Core_Block_Abstract
{

    /** @var Zend_Config */
    protected $config;

    function getConfig()
    {
        if( !$this->config instanceof Zend_Config )
        {
            $this->config = VF_Singleton::getInstance()->getConfig();
        }
        return $this->config;
    }

    function setConfig( Zend_Config $config )
    {
        $this->config = $config;
    }

    function _toHtml()
    {
	if (VF_Singleton::getInstance()->getConfig()->logo->disable)
	{
	    return;
	}
	if (!$this->selectionPart())
	{
	    return;
	}
	$pathSuffix = $this->selectionToken() . '.' . $this->extension();
	return '<img class="vafLogo" src="/logos/' . $pathSuffix . '" />';
    }

    function extension()
    {
	if($this->getConfig()->logo->extension)
	{
	    return $this->getConfig()->logo->extension;
	}
	return 'PNG';
    }

    function selectionPart()
    {
	$vehicleSelection = VF_Singleton::getInstance()->vehicleSelection();
	if ($vehicleSelection->isEmpty())
	{
	    return false;
	}
	
	if($this->getConfig()->logo->level)
	{
	    $level = $this->getConfig()->logo->level;
	    return $vehicleSelection->getLevel($level)->__toString();
	}

	$schema = new VF_Schema;
	if(in_array('make', $schema->getLevels()))
	{
	    $make = $vehicleSelection->getLevel('make');
	    if (!$make)
	    {
		return false;
	    }
	    return $make->__toString();
	}

	$rootLevel = $schema->getRootLevel();
	return $vehicleSelection->getLevel($rootLevel)->__toString();
    }

    function selectionToken()
    {
	$selectionPart = $this->selectionPart();
	return basename(strtoupper(str_replace(' ', '-', $selectionPart)));
    }

}