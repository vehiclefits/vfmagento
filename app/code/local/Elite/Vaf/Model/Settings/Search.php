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
class Elite_Vaf_Model_Settings_Search extends Zend_Form
{
    protected $config;
    
    function init()
    {
        $this->addElement('text','loadingText', array(
            'label'=>'loadingText',
            'description'=> 'text to show in the drop-down while the ajax is processing

Set text you want to appear in each dropdown while the ajax is loading, if left blank or ommited defaults to "loading". You may set it to an empty string ("") to have no loading text.',
            'value' => $this->getConfig()->search->loadingText
        ));
        $this->addElement('text','searchButton', array(
            'label'=>'searchButton',
            'description'=> 'Changes the operation of the submit button. Defaults to "button". Set to "button" to show a submit button. Set to "link" to show a submit link. Set to "hide" and there will be no submit button (it will auto-submit after any change of vehicle).',
            'value' => $this->getConfig()->search->searchButton
        ));
        $this->addElement('text','clearButton', array(
            'label'=>'clearButton',
            'description'=> ' Changes the clear button. Defaults to "button". Set to "button" to show a clear button. Set to "link" to show a clear link. Set to "hide" and there will be no clear link.',
            'value' => $this->getConfig()->search->clearButton
        ));
        $this->addElement('text','defaultText', array(
            'label'=>'defaultText',
            'description'=> 'Text to use as the default option prompting user to make selection. Defaults to "-please select-" if you do not override it. Use %s to put the current level. Example "- Pick %s -" will cause each drop down to read "- Pick Make -", "- Pick Year -",etc.',
            'value' => $this->getConfig()->search->defaultText
        ));
        $this->addElement('text','labels', array(
            'label'=>'labels',
            'description'=> ' Set to false if you don\'t want labels in front of the select boxes. Defaults to true.',
            'value' => $this->getConfig()->search->labels ? 'true' : 'false'
        ));
        $this->addElement('text','unavailableSelections', array(
            'label'=>'unavailableSelections',
            'description'=> 'What to do with unavailable selections? show, hide, disable. Default = show.

Before the user completely makes all selections you have several drop downs that are just blank. Several popular automotive shops have the feature for drop downs to be "hidden" or disabled before the selection is ready. Set this option to "show", "disable", or "hide". If you do not set it, it will default to "show".',
            'value' => $this->getConfig()->search->unavailableSelections
        ));
        $this->addElement('text','insertBrTag', array(
            'label'=>'insertBrTag',
            'description'=> 'Wether or not to insert a <br /> tag between each level. Set to true/false. Defaults to true. ',
            'value' => $this->getConfig()->search->insertBrTag ? 'true' : 'false'
        ));
        $this->addElement('text','loadingStrategy', array(
            'label'=>'loadingStrategy',
            'description'=> 'Loading strategy (ajax/non ajax). Defaults to "ajax". Set to "offline" for smaller data sets to get faster, smoother loading.',
            'value' => $this->getConfig()->search->loadingStrategy
        ));
        $this->addElement('text','submitAction', array(
            'label'=>'submitAction',
            'description'=> 'Where to submit the search form. Valid options are to set this to: "homepagesearch". Setting it to any other value will cause the value to be treated as a URL. In this way you can have the form post to a URL of your choice (like a specific category or CMS page). If the user is on a category page, the form will submit to the same page (filter the current results) unless you also set the \'submitOnCategoryAction\' setting. If at any time the category chooser is active on any given page, the form will ALWAYS post the category that the user selects. ',
            'value' => $this->getConfig()->search->submitAction
        ));
        $this->addElement('text','submitOnCategoryAction', array(
            'label'=>'submitOnCategoryAction',
            'description'=> 'Where to submit the search form when the user is viewing a "category view" page. You may either set this to "refresh", or "homepagesearch", or a specific URL. If not specified, this value defaults to refresh. If at any time the category chooser is active on any given page, the form will ALWAYS post the category that the user selects. ',
            'value' => $this->getConfig()->search->submitOnCategoryAction
        ));
        $this->addElement('text','submitOnProductAction', array(
            'label'=>'submitOnProductAction',
            'description'=> 'Where to submit the search form when the user is viewing a "product view" page. You may either set this to "refresh", or "homepagesearch", or a specific URL. If not specified, the value of "submitAction" is used on the product page, if it were specified. If at any time the category chooser is active on any given page, the form will ALWAYS post the category that the user selects. ',
            'value' => $this->getConfig()->search->submitOnProductAction
        ));
        $this->addElement('text','submitOnHomepageAction', array(
            'label'=>'submitOnHomepageAction',
            'description'=> 'Where to submit the search form when the user is viewing the home page. You may either set this to "refresh", or "homepagesearch", or a specific URL. Defaults to "homepagesearch". If not specified, the value of "submitAction" is used on the home page, if it were specified. If at any time the category chooser is active on any given page, the form will ALWAYS post the category that the user selects. ',
            'value' => $this->getConfig()->search->submitOnHomepageAction
        ));
        $this->addElement('text','categoriesThatSubmitToHomepage', array(
            'label'=>'categoriesThatSubmitToHomepage',
            'description'=> ' List category IDs separated by comma that should always submit to the "homepage search results" ',
            'value' => $this->getConfig()->search->categoriesThatSubmitToHomepage 
        ));
        $this->addElement('text','categoriesThatRefresh', array(
            'label'=>'categoriesThatRefresh',
            'description'=> 'List category IDs separated by comma that should always refresh on submit ',
            'value' => $this->getConfig()->search->categoriesThatRefresh 
        ));
        $this->addElement('text','vehicleTemplate', array(
            'label'=>'vehicleTemplate',
            'description'=> ' Customize how the vehicle is displayed, for example if your schema is "year,make,model" it would default to displaying vehicles like "2000 Honda Civic" but with this you could have it show "2000 Civic" by setting the vehicleTemplate to "%year% %model%"',
            'value' => $this->getConfig()->search->vehicleTemplate
        ));
        $this->addElement('text','storeVehicleInSession', array(
            'label'=>'storeVehicleInSession',
            'description'=> 'Set to false to not store the vehicle in the user\'s session. Defaults to true.',
            'value' => $this->getConfig()->search->storeVehicleInSession ? 'true' : 'false'
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