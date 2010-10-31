<?php
class Elite_Vaf_Model_Merge
{
    protected $config;
    protected $slaveLevels;
    protected $masterLevel;
    protected $operating_grain;
    
    /**
    * @param aray $slaveLevels - Ex. array('year'=>$year1,'year'=>$year2);
    * @param array $masterLevel - Ex. array('year'=>$year2);
    */
    function __construct( $slaveLevels, $masterLevel )
    {
        $this->slaveLevels = $slaveLevels;
        $this->masterLevel = $masterLevel;
    }
    
    function execute()
    {
        $master_level_type = current($this->masterLevel);
        
        $this->setMasterVehicle();
        $master_vehicle = $this->masterVehicle();
        
        $this->operating_grain = $master_level_type;
        
        $this->ensureSameGrain();
        
        $slaveVehicles = $this->slaveVehicles();
        foreach($slaveVehicles as $slaveVehicle)
        {
            if($this->equalsAboveOperatingGrain($slaveVehicle, $master_vehicle))
            {
                continue;
            }
            
            $this->merge_vehicle($slaveVehicle, $master_vehicle);
            $this->unlinkSlaves($slaveVehicle, $master_vehicle);
        }
    }
    
    function operatingGrain()
    {
        return $this->operating_grain;
    }
    
    function setMasterVehicle()
    {
        $this->master_vehicle = next($this->masterLevel);
    }
    
    function masterVehicle()
    {
        return $this->master_vehicle;
    }
    
    function slaveVehicles()
    {
        $slaveVehicles = array();
        
        foreach($this->slaveLevels as $levelsToBeMergedArray)
        {
            $vehicle_object = next($levelsToBeMergedArray);
            
            $levelIds = $vehicle_object->levelIdsTruncateAfter($this->operatingGrain());
            $slaveVehicles = array_merge($slaveVehicles, $this->vehicleFinder()->findByLevelIds($levelIds));
        }
        
        foreach($slaveVehicles as $slaveVehicle)
        {
            $slaveVehicle->toValueArray();
        }
        return $slaveVehicles;
    }
    
    function ensureSameGrain()
    {
        $last_level_type = '';
        $i=0;
        foreach($this->slaveLevels as $levelsToBeMergedArray)
        {
            $level_type = current($levelsToBeMergedArray);
            if($last_level_type != $level_type && $i)
            {
                throw new Elite_Vaf_Model_Vehicle_Finder_Exception_DifferingGrain('slave levels should all be at same grain to merge');
            }
            $last_level_type = $level_type;
            $i++;
        }
        
        if( $last_level_type != $this->operatingGrain() )
        {
            throw new Elite_Vaf_Model_Vehicle_Finder_Exception_DifferingGrain('master level must be at same grain as slave levels');
        }
    }
    
    function unlinkSlaves($slaveVehicle, $master_vehicle )
    {
        if( !$this->equalsAboveOperatingGrain($slaveVehicle, $master_vehicle))
        {
            $params = $slaveVehicle->levelIdsTruncateAfter($this->operatingGrain());
            $unlinkTarget = $this->vehicleFinder()->findOneByLevelIds($params, Elite_Vaf_Model_Vehicle_Finder::EXACT_ONLY);
            if($unlinkTarget)
            {
                $unlinkTarget->unlink();
            }
        }
    }
    
    function equalsAboveOperatingGrain($vehicle1, $vehicle2)
    {
        return $vehicle1->levelIdsTruncateAfter($this->operatingGrain()) == $vehicle2->levelIdsTruncateAfter($this->operatingGrain());
    }
    
    function merge_vehicle($slave_vehicle, $master_vehicle)
    {
        $titles = $slave_vehicle->toTitleArray();
        $levelsToReplace = $this->getSchema()->getPrevLevelsIncluding($this->operatingGrain());
        foreach( $levelsToReplace as $levelToReplace )
        {
            $titles[$levelToReplace] = $master_vehicle->getLevel($levelToReplace)->getTitle();
        }
        $new_vehicle = Elite_Vaf_Model_Vehicle::create($this->getSchema(), $titles);
        $new_vehicle->save();
        
        $this->mergeFitments($slave_vehicle, $new_vehicle);
    }
    
    function vehicleFinder()
    {
        return new Elite_Vaf_Model_Vehicle_Finder($this->getSchema());
    }
    
    function mergeFitments($vehicle_object, $master_vehicle)
    {
        foreach($this->getProductsThatFit($vehicle_object) as $product)
        {
            $params = $master_vehicle->levelIdsTruncateAfter($this->operatingGrain());
            $descendantsOfMaster = $this->vehicleFinder()->findOneByLevelIds($params);
            $product->addVafFit($master_vehicle->toValueArray());
        }
    }
    
    function getProductsThatFit($vehicle_object)
    {
        $select = new Elite_Vaf_Select($this->getReadAdapter());
        $select
            ->from('elite_mapping')
            ->whereLevelIdsEqual($vehicle_object->toValueArray());
        
        $result = $select->query()->fetchAll();
        $products = array();
        foreach($result as $row)
        {
            $product = new Elite_Vaf_Model_Catalog_Product();
            $product->setId($row['entity_id']);
            array_push($products, $product);
        }
        return $products;
    }
    
    function getSchema()
    {
        $schema = new Elite_Vaf_Model_Schema;
        $schema->setConfig( $this->getConfig() );
        return $schema;
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
    
    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getReadAdapter();
    }
}