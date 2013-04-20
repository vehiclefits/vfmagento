<?php
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

Ignores any category IDs listed, they will not show up in the "category chooser". List them out seperated by comma. If you do not put an ignore paramater then all categories will be listed by default.',
            'value' => $this->getConfig()->categorychooser->ignore
        ));
        
        $this->addElement('submit','save', array('label'=>'Save'));
        
    }

    function getConfig()
    {
	if (!$this->config instanceof Zend_Config)
	{
	    $this->config = Elite_Vaf_Helper_Data::getInstance()->getConfig();
	}
	return $this->config;
    }

}