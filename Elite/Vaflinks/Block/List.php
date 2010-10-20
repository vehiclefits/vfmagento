<?php
class Elite_Vaflinks_Block_List extends Elite_Vaf_Block_Search
{
    function __construct()
    {
         parent::__construct();
         $this->setTemplate('vaflinks/list.phtml');
    }
    
    function getDefinitions()
    {
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        if( $this->lastLevelAlreadySelected() )
        {
            return array();
        }

        $vehicles = array();
        $vehicleFinder = new Elite_Vaf_Model_Vehicle_Finder( $this->getSchema() );
        foreach( $this->getItems() as $level )
        {
            array_push( $vehicles, $vehicleFinder->findByLevel( $level->getType(), $level->getId() ) ); 
        }
        return $vehicles;
    }
    
    protected function lastLevelAlreadySelected()
    {
        return $this->getFlexible()->getLevel() == $this->getSchema()->getLeafLevel();
    }
    
    function getItems()
    {
        $level = $this->getListLevel();
        $items = $this->listEntities( $level );
        return $items;
    }
    
    function getListLevel()
    {
        $flexible = $this->getFlexible();
        if( !$flexible->getLevel() )
        {
            return $this->getSchema()->getRootLevel();
        }
        
        $level = $flexible->getLevel();
        $level = $this->getSchema()->getNextLevel( $level );
        if( $level )
        {
            return $level;
        }
        return $this->getSchema()->getRootLevel();
        
    }
    
    function vafUrl( Elite_Vaf_Model_Vehicle $vehicle )
    {
        $params = http_build_query($vehicle->toValueArray());
        if( $vehicle->getLeafValue() )
        {
            if('/' == $this->getRequest()->getBasePath())
            {
                return '/vaf/product/list?' . $params;
            }
            return $this->getRequest()->getBasePath() . '/vaf/product/list?' . $params;
        }
        return '?' . $params;
    }
    
    protected function getFlexible()
    {
        return new Elite_Vaf_Model_FlexibleSearch( $this->getSchema(), $this->getRequest() );
    }
    
    protected function getSchema()
    {
        return new Elite_Vaf_Model_Schema;    
    }
    
    protected function _toHtml()
    {
    	if( !Elite_Vaf_Helper_Data::getInstance()->enableDirectory() )
    	{
			return;
    	}

        return parent::_toHtml();
    }
}