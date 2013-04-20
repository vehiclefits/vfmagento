<?php
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
	    $this->config = Elite_Vaf_Helper_Data::getInstance()->getConfig();
	}
	return $this->config;
    }

}