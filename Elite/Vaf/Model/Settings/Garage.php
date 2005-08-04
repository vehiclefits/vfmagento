<?php
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
	    $this->config = Elite_Vaf_Helper_Data::getInstance()->getConfig();
	}
	return $this->config;
    }

}