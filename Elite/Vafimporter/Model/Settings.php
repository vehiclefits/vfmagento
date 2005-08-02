<?php
class Elite_Vafimporter_Model_Settings extends Zend_Form
{
    protected $config;
    
    function init()
    {
        $this->addElement('text','allowMissingFields', array(
            'label'=>'allowMissingFields',
            'description'=> 'Defaults to false. If set to true, import files will be accepted with less than all the "levels". Missing levels will be treated as if they were included but every row set to "Base".',
            'value' => $this->allowMissingFields()
        ));
        
        $this->addElement('text','Y2KMode', array(
            'label'=>'Y2KMode',
            'description'=> 'Defaults to true, enables Y2k Mode. Converts 2 digit years to 4 digit years as per the Vehicles List Import documentation.',
            'value' => $this->Y2kMode()
        ));
        
        
        $this->addElement('text','Y2KThreshold', array(
            'label'=>'Y2KThreshold',
            'description'=> 'Defaults to 25. If a two digit year is less than this number, it assumed to mean 21st century; otherwise 20th century. ',
            'value' => $this->Y2KThreshold()
        ));
        
        $this->addElement('submit','save', array('label'=>'Save'));
        
    }
    
    function allowMissingFields()
    {
	return $this->getConfig()->importer->allowMissingFields ? 'true' : 'false';
    }
    
    function Y2kMode()
    {
	return $this->getConfig()->importer->Y2kMode ? 'true' : 'false';
    }
    
    function Y2KThreshold()
    {
	return $this->getConfig()->importer->Y2KThreshold;
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