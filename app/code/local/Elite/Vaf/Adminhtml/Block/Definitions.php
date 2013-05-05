<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Elite_Vaf_Adminhtml_Block_Definitions extends Elite_Vaf_Block_Abstract implements VF_Configurable
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
            
            $this->config = VF_Singleton::getInstance()->getConfig();
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
        return new VF_Level( $entity );
    }
    
    protected function getNextLevel()
    {
        return $this->getEntity()->getNextLevel();
    }
    
    function getDefaultLevel()
    {
        $schema = new VF_Schema;
        $schema->setConfig( $this->getConfig() );
        return $schema->getRootLevel();
    }
    
    function schema()
    {
        return new VF_Schema();
    }
}