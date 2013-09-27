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
class Elite_Vaf_Model_Settings_Category extends Zend_Form
{
    protected $config;
    
    function init()
    {
        $this->addElement('text','disable', array(
            'label'=>'disable',
            'description'=> 'Disable filtering on all category pages.

This is if you want the vehicle search to "be seperate" from your main store, for "window shopping" style. If disable is set to true, the extension will provide the make/model/year search form and filter on all category pages by default, unless white/black listing is in effect.',
            'value' => $this->getConfig()->category->disable
        ));
        
        $this->addElement('text','mode', array(
            'label'=>'mode',
            'description'=> 'Change the category mode for when user clicks through to a category page.

Defaults to "default". Alternatively specify "group" for \'group view\' on every category page.',
            'value' => $this->getConfig()->category->mode
        ));
        
        $this->addElement('text','whitelist', array(
            'label'=>'whitelist',
            'description'=> 'Allows you to control for which categories filtering is enabled. Should be a comma separated list of category IDs. ',
            'value' => $this->getConfig()->category->whitelist
        ));
        
        $this->addElement('text','blacklist', array(
            'label'=>'blacklist',
            'description'=> ' Allows you to control for which categories filtering is disabled. Should be a comma separated list of category IDs.
For instance if only one of your categories is applicable to the make/model/year search. Works according to these rules:

    If whitelisting is specified, and the customer is on the category specified, the they will see the filter.
    If blacklist is specified, and the customer is on the category specified, the they will not see the filter.
    If neither is specified, the value of "disabled" will control wether the customer will see the filter.

Example Usage:
whitelist = "4,3,2"; only enable the search on this category
blacklist = "1,2,3" ; do not enable the search on this category ',
            'value' => $this->getConfig()->category->blacklist
        ));
        
        $this->addElement('text','requireVehicle', array(
            'label'=>'requireVehicle',
            'description'=> 'Allows you to require user to select a vehicle before seeing products. Should be a comma separated list of category IDs. Optionally set to "all" to match all category IDs.
Example Usage:
requireVehicle = "1,2,3"
requireVehicle = "all"
The splash page that is shown can be edited in vaf/splash.phtml ',
            'value' => $this->getConfig()->category->blacklist
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