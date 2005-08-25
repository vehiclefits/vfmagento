<?php
class Elite_Vafdiagram_Model_Vehicle
{
	/** @var VF_Vehicle */
    protected $wrappedVehicle;
    
    function __construct(VF_Vehicle $vehicle )
    {
        $this->wrappedVehicle = $vehicle;
    }
    
	function serviceCode()
    {
    	$select = $this->getReadAdapter()->select()
            ->from('elite_definition', array('service_code'));
		foreach($this->toValueArray() as $key=>$val)
		{
			$select->where($key . '_id = ?', $val);
		}
        
        $result = $this->query($select);
        return $result->fetchColumn();
    }
    
	function __call($methodName,$arguments)
    {
        $method = array($this->wrappedVehicle,$methodName);
        return call_user_func_array( $method, $arguments );
    }
    
	function query($sql)
    {
    	return $this->getReadAdapter()->query($sql);
    }
    
 	/** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
}