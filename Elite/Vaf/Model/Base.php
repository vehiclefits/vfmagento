<?php
abstract class Elite_Vaf_Model_Base
{
    protected $config;
    
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
    
    function vehicleFinder()
    {
        return new Elite_Vaf_Model_Vehicle_Finder($this->getSchema());
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