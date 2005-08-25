<?php
/**
* Vehicle Fits Free Edition - Copyright (c) 2008-2010 by Vehicle Fits, LLC
* PROFESSIONAL IDENTIFICATION:
* "www.vehiclefits.com"
* PROMOTIONAL SLOGAN FOR AUTHOR'S PROFESSIONAL PRACTICE:
* "Automotive Ecommerce Provided By Vehicle Fits llc"
*
* All Rights Reserved
* VEHICLE FITS ATTRIBUTION ASSURANCE LICENSE (adapted from the original OSI license)
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the conditions in license.txt are met
*/
class Elite_Vaf_Model_Observer extends Mage_Core_Model_Abstract 
{
    function catalogProductEditAction( $event )
    {
        $product = Mage::registry( 'current_product' );
        if( !is_object( $product ) )
        {
            return;
        }
        $controller = $event->getControllerAction();
        $request = $controller->getRequest();

        $this->removeFitments($request,$product);
        $this->updateUniversal($product);
        $this->updateRelated($product);
        $this->addNewFitments($request,$product);
        
        $this->dispatchProductEditEvent( $controller, $product );
    }

    function removeFitments($request,$product)
    {
        $schema = new VF_Schema();
        if( is_array( $request->getParam( 'vaf-delete' ) ) && count( $request->getParam( 'vaf-delete' ) ) >= 1 )
        {
            foreach( $request->getParam( 'vaf-delete', array() ) as $fit )
            {
                $fit = explode( '-', $fit );
                $level = $fit[0];
                $fit = $fit[1];
                if( $level == $schema->getLeafLevel() )
                {
                    $product->deleteVafFit( $fit );
                }
            }
        }
    }

    function updateUniversal($product)
    {
        if( isset( $_POST['universal'] ) && $_POST['universal'] )
        {
            $product->setUniversal( true );
        }
        else
        {
            $product->setUniversal( false );
        }
    }

    function updateRelated($product)
    {
        if (file_exists(ELITE_PATH . '/Vafrelated'))
	{
	    $relatedProduct = new Elite_Vafrelated_Model_Catalog_Product($product);
	    if( isset( $_POST['related'] ) && $_POST['related'] )
	    {
		$relatedProduct->setShowInRelated( true );
	    }
	    else
	    {
		$relatedProduct->setShowInRelated( false );
	    }
	}
    }

    function addNewFitments($request,$product)
    {
        if( is_array( $request->getParam( 'vaf' ) ) && count( $request->getParam( 'vaf' ) ) >= 1 )
        {
            foreach( $request->getParam( 'vaf' ) as $fit )
            {
                if( strpos($fit,':') && strpos($fit,';') )
                {
                    // new logic
                    $params = explode(';', $fit);
                    $newParams = array();
                    foreach($params as $key => $value)
                    {
                        $data = explode(':', $value);
                        if(count($data)<=1) continue;
                         
                        $newParams[$data[0]] = $data[1];
                    }
                    $product->addVafFit($newParams);
                }
                else
                {
                    //legacy logic

                    $fit = explode( '-', $fit );
                    $level = $fit[0];
                    $fit = $fit[1];
                    $product->addVafFit( array( $level=> $fit ) );
                }
            }
        }
    }
    
    function doTabs( $event )
    {
        $block = $event->block;
        $suffix = 'Catalog_Product_Edit_Tabs';
        $blockClass = get_class( $block );
        if( strpos( $blockClass, $suffix ) != 0 )
        {
            $contents = $block->getLayout()->createBlock( 'adminhtml/catalog_product_edit_tab_vaf' );
            $contents = $contents->toHtml();
            $block->addTab('vaf', array(
                'label'     => Mage::helper('catalog')->__('Vehicle Fits'),
                'content' => $contents
            ));
        }
    }
    
    function deleteModelBefore( $event )
    {
        $product = $event->object;
        if( get_class( $product ) != 'Elite_Vaf_Model_Catalog_Product' )
        {
            return;
        }
        $this->query(
            sprintf(
                "DELETE FROM `elite_mapping` WHERE `entity_id` = %d",
                (int)$product->getId()
            )
        );
    }
    
    /** array('order'=>$order, 'quote'=>$this->getQuote()) */
    function checkoutSaveOrder( $event )
    {
        $fit_id = Elite_Vaf_Helper_Data::getInstance()->getFitId();
        if( $fit_id )
        {
            $event->order->setEliteFit( $fit_id  );
        }
    }
  
    protected function dispatchProductEditEvent( $controller, $product )
    {
        Mage::dispatchEvent('elite_vaf_product_edit', array(
            'controller'  => $controller,
            'product' => $product
        ));
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
