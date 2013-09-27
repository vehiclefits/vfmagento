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
class Elite_Vaf_Model_Settings_Product extends Zend_Form
{
    protected $config;
    
    function init()
    {
        $this->addElement('text','requireVehicleBeforeCart', array(
            'label'=>'requireVehicleBeforeCart',
            'description'=> 'Require the user to choose a vehicle before adding product to cart

    Set to true to require the user to choose a vehicle before adding product to cart. If enabled users will be presented with an intermediate page, and asked to choose their vehicle from a list of compatable vehicles before adding the product to the cart. The default behavior is for this to be turned off, unless you set it to true.*[1][2]

*[1] Will only affect categories that are enabled. Will only affect product that are in enabled categories. If product is in both a blacklisted & whitelisted category, it will be treated as if it is whitelisted.
*[2] Will only occur if the product actually has fitments mapped to it, if not there would be no possible choices and it would not make sense to show it.',
            'value' => $this->getConfig()->product->requireVehicleBeforeCart ? 'true' : 'false'
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