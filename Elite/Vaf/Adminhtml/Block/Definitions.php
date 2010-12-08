<?php
/**
* Vehicle Fits Free Edition - Copyright (c) 2008-2010 by Ne8, LLC
* PROFESSIONAL IDENTIFICATION:
* "www.vehiclefits.com"
* PROMOTIONAL SLOGAN FOR AUTHOR'S PROFESSIONAL PRACTICE:
* "Automotive Ecommerce Provided By Ne8 llc"
*
* All Rights Reserved
* VEHICLE FITS ATTRIBUTION ASSURANCE LICENSE (adapted from the original OSI license)
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the conditions in license.txt are met
*/
class Elite_Vaf_Adminhtml_Block_Definitions extends Elite_Vaf_Block_Abstract implements Elite_Vaf_Configurable
{
    /** @var Zend_Config */
    protected $config;
    
    /** result set for index action */
    public $rs;
    
    /** model deleting for index action */
    public $model;
    
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
    
    protected function editing( $id = 0 )
    {
		if(!$id)
		{
			return $this->getRequest()->getParam('edit') != 0;
		}
        return $this->getRequest()->getParam( 'edit', 0 ) == $id;
    }
    
    protected function getEditUrl( $id )
    {
        $url = Mage::helper('adminhtml')->getUrl('*/*/*', array(
            'edit' => $id,
            'entity' => $this->getEntity()->getType(),
        ));
        
        $params = $this->requestLevels();
        $url .= '?' . http_build_query($params);
        return $url;
    }
    
    protected function getDeleteUrl( $id, $confirm = 0 )
    {
        $url = Mage::helper('adminhtml')->getUrl('*/*/delete', array(
            'delete' => $id,
            'confirm' => $confirm,
            'entity' => $this->getEntity()->getType(),
            'id' => $this->getCurrentId()
        ));
        
        $params = $this->requestLevels();
        $url .= '?' . http_build_query($params);
        return $url;
    }
    
    protected function getSaveUrl( $id = 0 )
    {
        $url = Mage::helper('adminhtml')->getUrl('*/*/save', array(
            'entity' => $this->getEntity()->getType(),
            'id' => $this->getCurrentId(),
            'save' => $id
        ));
        
        
        return $url;
    }
    
    protected function getListUrl( $entityType, $id )
    {
        $url = Mage::helper('adminhtml')->getUrl('*/*/index', array(
            'entity' => $entityType,
            'id' => $id
        ));
        
        $params = $this->vafParams($id);
        $url .= '?' . http_build_query($params);
        return $url;
    }
    
    function mergeUrl()
    {
        return Mage::helper('adminhtml')->getUrl('*/*/merge') .
            '?' . http_build_query($this->requestLevels()) .
            '&entity=' . $this->getEntity()->getType();
    }
    
    function splitUrl($id)
    {
        return Mage::helper('adminhtml')->getUrl('*/*/split') .
            '?' . http_build_query($this->requestLevels()) .
            '&entity=' . $this->getEntity()->getType() .
            '&id=' . $id;
    }
    
    function productUrl($id)
    {
        $params = $this->requestLevels();
        $params[$this->getEntity()->getType()] = $id;
        return Mage::helper('adminhtml')->getUrl('*/*/product', array(
            'entity' => $this->getEntity()->getType()
        )) . '?' . http_build_query($params);
    }
    
    function requestLevels()
    {
        $params = array();
        foreach($this->schema()->getLevels() as $level)
        {
            if($this->getRequest()->getParam($level))
            {
                $params[$level] = $this->getRequest()->getParam($level);
            }
        }
        return $params;
    }
    
    function vafParams($id)
    {
        $type = $this->getEntity()->getType();
        $return = array();
        foreach( $this->schema()->getPrevLevelsIncluding($type) as $level )
        {
            $return[$level] = $this->getRequest()->getParam($level);
        }
        $return[$type] = $id;
        return $return;
    }
    
    function getEntity()
    {
        $entity = $this->getRequest()->getParam( 'entity' );
        if( empty( $entity ) )
        {
            $entity = $this->getDefaultLevel();
        }
        return new Elite_Vaf_Model_Level( $entity );
    }
    
    protected function getNextLevel()
    {
        return $this->getEntity()->getNextLevel();
    }
    
    function getDefaultLevel()
    {
        $schema = new Elite_Vaf_Model_Schema;
        $schema->setConfig( $this->getConfig() );
        return $schema->getRootLevel();
    }
    
    function schema()
    {
        return new Elite_Vaf_Model_Schema();
    }
}