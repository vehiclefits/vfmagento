<?php
class Elite_Vaftire_Model_Vehicle
{
    /** @var VF_Vehicle */
    protected $wrappedVehicle;
    
    function __construct(VF_Vehicle $vehicle )
    {
        $this->wrappedVehicle = $vehicle;
    }
    
    /** @return Elite_Vaftire_Model_TireSize */
    function tireSize()
    {
        $select = $this->getReadAdapter()->select()
            ->from('elite_vehicle_tire', array('section_width','aspect_ratio','diameter'))
            ->where('leaf_id = ?', (int)$this->wrappedVehicle->getLeafValue() );
        
        $result = $this->query($select);
        
        $return = array();
        foreach( $result->fetchAll(Zend_Db::FETCH_OBJ) as $tireSizeStd )
        {
            array_push($return, new Elite_Vaftire_Model_TireSize($tireSizeStd->section_width, $tireSizeStd->aspect_ratio, $tireSizeStd->diameter ) );
        }
        return $return;
    }
    
    function addTireSize( Elite_Vaftire_Model_TireSize $tireSize )
    {
        $select = $this->getReadAdapter()->select()
            ->from('elite_vehicle_tire')
            ->where('leaf_id = ?', (int)$this->wrappedVehicle->getLeafValue())
            ->where('section_width = ?', (int)$tireSize->sectionWidth())
            ->where('aspect_ratio = ?', (int)$tireSize->aspectRatio())
            ->where('diameter = ?', (int)$tireSize->diameter());
        
        $result = $select->query();
        if($result->fetchColumn())
        {
            return;
        }
        
        $this->getReadAdapter()->insert('elite_vehicle_tire', array(
            'leaf_id' => (int)$this->wrappedVehicle->getLeafValue(),
            'section_width' => $tireSize->sectionWidth(),
            'aspect_ratio' => $tireSize->aspectRatio(),
            'diameter' => $tireSize->diameter(),
        ));
    }
    
    function vehicle()
    {
    	return $this->wrappedVehicle;
    }
    
    function __call($methodName,$arguments)
    {
        $method = array($this->wrappedVehicle,$methodName);
        return call_user_func_array( $method, $arguments );
    }
    
    /** @return Zend_Db_Statement_Interface */
    protected function query( $sql )
    {
        return $this->getReadAdapter()->query( $sql );
    }
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
}