<?php
abstract class Elite_Vafimporter_Model extends Ne8Vehicle_Import_Abstract implements Elite_Vaf_Configurable
{
    const E_WARNING = 1;
    
    protected $count = 0;
    
    /** @var Zend_Config */
    protected $config;
    
    abstract function import();
    
    /** @return array Field positions keyed by the field's names */
    function getFieldPositions()
    {
		parent::getFieldPositions();
        if( false == $this->fieldPositions )
        {
            throw new Elite_Vafimporter_Model_VehiclesList_CSV_Exception_FieldHeaders('Field headers missing');
        }
		foreach($this->schema()->getLevels() as $level)
        {
            if( !$this->allowMissingFields() &&
                !isset($this->fieldPositions[$level]) && (
                !isset($this->fieldPositions[$level.'_start']) && !isset($this->fieldPositions[$level.'_end']) ) &&
                !isset($this->fieldPositions[$level.'_range'])
            )
            {
                throw new Elite_Vafimporter_Model_VehiclesList_CSV_Exception_FieldHeaders('Unable to locate field header for ['.$level.'], perhaps not using comma delimiter');
            }
        }
        return $this->fieldPositions;
    }
    
    function allowMissingFields()
    {
        return $this->getConfig()->importer->allowMissingFields;
    }
    
    function getConfig()
    {
        if( !$this->config instanceof Zend_Config )
        {
            $this->config = Elite_Vaf_Helper_Data::getInstance()->getConfig();
        }    
        return $this->config;
    }
    
    function setConfig( Zend_Config $config )
    {
        $this->config = $config;
    }
    
}
