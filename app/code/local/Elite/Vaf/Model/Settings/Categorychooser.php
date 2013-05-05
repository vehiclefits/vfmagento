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
class Elite_Vaf_Model_Settings_Categorychooser extends Zend_Form
{
    protected $config;
    
    function init()
    {
        $this->addElement('text','onHomepage', array(
            'label'=>'onHomepage',
            'description'=> 'Show the category chooser on the homepage

    Set to true to place a chooser on the homepage. Set to false and the customer will never see a category chooser on the homepage. If not specified, the system would default to the below option "onAllPages". If neither option is specified, there will be no category chooser on any page. If both options are specified, the value of "onHomepage" will always take presdence for the homepage',
            'value' => $this->getConfig()->categorychooser->onHomepage
        ));
        $this->addElement('text','onAllPages', array(
            'label'=>'onAllPages',
            'description'=> 'Show category chooser on pages other than homepage

Set to true to place the chooser on all pages. Note that if "onHomepage" (see previous option) is specified as well, it\'s value will take presedence on the homepage.',
            'value' => $this->getConfig()->categorychooser->onAllPages
        ));
        $this->addElement('text','allOptionOnHomepage', array(
            'label'=>'allOptionOnHomepage',
            'description'=> '',
            'value' => $this->getConfig()->categorychooser->allOptionOnHomepage
        ));
        $this->addElement('text','allOptionOnAllPages', array(
            'label'=>'allOptionOnAllPages',
            'description'=> 'Show "all" as the first option of the category chooser (for homepage)

Set to true to have "All" as a category option on homepage. Follows same rules as onHomepage & onAllPages regarding precedence',
            'value' => $this->getConfig()->categorychooser->allOptionOnAllPages
        ));
        $this->addElement('text','allCategoryOptionText', array(
            'label'=>'allCategoryOptionText',
            'description'=> 'text to show for the "all categories" option

Set to the text you want to use in place of "All" on the category chooser, if ommited or blank, "All" will be used by default.',
            'value' => $this->getConfig()->categorychooser->allCategoryOptionText
        ));
        $this->addElement('text','ignore', array(
            'label'=>'ignore',
            'description'=> 'Category IDs to ignore

Ignores any category IDs listed, they will not show up in the "category chooser". List them out separated by comma. If you do not put an ignore paramater then all categories will be listed by default.',
            'value' => $this->getConfig()->categorychooser->ignore
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