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
class Elite_Vaf_Model_Settings_Logo extends Zend_Form
{
    protected $config;
    
    function init()
    {
        $this->addElement('text','disable', array(
            'label'=>'loadingText',
            'description'=> 'Disable the module. Set to true or false. ',
            'value' => $this->getConfig()->logo->disable
        ));       
        $this->addElement('text','extension', array(
            'label'=>'extension',
            'description'=> 'Defaults to \'PNG\', set to the file extension that will become the filename suffix for your logos. ',
            'value' => $this->getConfig()->logo->extension
        ));       
        $this->addElement('text','level', array(
            'label'=>'level',
            'description'=> 'Defaults to "make", or if there is no level called "make" in your schema, your root (first) level. Specify this setting to override which level is used for the logo\'s filename. ',
            'value' => $this->getConfig()->logo->level
        ));       
        $this->addElement('submit','save', array('label'=>'Save'));
        
    }

    function getConfig()
    {
	if (!$this->config instanceof Zend_Config)
	{
	    $this->config = VF_Singleton::getInstance()->getConfig();
	}
	return $this->config;
    }

}