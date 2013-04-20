<?php
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
	    $this->config = Elite_Vaf_Helper_Data::getInstance()->getConfig();
	}
	return $this->config;
    }

}