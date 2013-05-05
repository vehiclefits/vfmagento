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
class Elite_Vaf_Model_Settings_Garage extends Zend_Form
{
    protected $config;
    
    function init()
    {
        $this->addElement('text','show', array(
            'label'=>'show',
            'description'=> 'Set to true to show the "My Garage" block. ',
            'value' => $this->getConfig()->mygarage->show ? 'true' : 'false'
        ));       
        $this->addElement('text','collapseAfterSelection', array(
            'label'=>'collapseAfterSelection',
            'description'=> 'Tuck away the search into "low profile mode" after selection is made.

Set to true to collapse the "year/make/model" search block. If enabled, the customer will only see the search drop downs when they first hit the home page. After they select their vehicle the drop downs will be hidden in favor of the smaller footprint "my garage" with change button.',
            'value' => $this->getConfig()->mygarage->collapseAfterSelection ? 'true' : 'false'
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