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
class Elite_Vaf_Model_Settings_Homepagesearch extends Zend_Form
{
    protected $config;
    
    function init()
    {
        $this->addElement('text','mode', array(
            'label'=>'mode',
            'description'=> 'Change the search results display mode

Valid values are "group", "category" or "grid".
    grid will enable a sortable native Magento grid grouping all products in one giant group.
    category will enable a category listing (See "category view").
    group will enable a javascript powered interface where products are grouped according to their location in the category tree',
            'value' => $this->getConfig()->homepagesearch->mode
        ));
        $this->addElement('text','exclude_categories', array(
            'label'=>'exclude_categories',
            'description'=> 'Specify comma delimited category ids to exclude those category\'s product from being included in the homepage search. Works for group view only (see \'mode\' setting above). ',
            'value' => $this->getConfig()->homepagesearch->exclude_categories
        ));
        
        $this->addElement('submit','save', array('label'=>'Save'));
        
    }

    function getConfig()
    {
	if (!$this->config instanceof Zend_Config)
	{
	    $this->config = Elite_Vaf_Singleton::getInstance()->getConfig();
	}
	return $this->config;
    }

}