<?php
class Elite_Vafbundle_Model_Bundle_Option extends Mage_Bundle_Model_Option
{
    function getSelections()
    {
        $vehicle = Elite_Vaf_Helper_Data::getInstance()->getFit();
        
        if( !$this->superProductFits($vehicle) )
        {
            return $this->getData('selections');
        }
        
        $selections = $this->getData('selections');
        if( !$selections )
        {
			return;
        }
        
        
        if( $vehicle && $vehicle->getLeafValue() )
        {
            $return = array();
            foreach( $selections as $product )
            {
                if( $this->productFits($product,$vehicle) )
                {
                    array_push( $return, $product );
                }
            }
            return $return;
        }
        
        return $selections;        
    }
    
    function productFits( $product, $vehicle )
    {
        $product->setCurrentlySelectedFit($vehicle);
        return $product->fitsSelection();
    }
    
    function superProductFits( $vehicle )
    {
        $superProduct = $this->superProduct();
        $superProduct->setCurrentlySelectedFit($vehicle);
        return $superProduct->fitsSelection();
    }
    
    function superProduct()
    {
        $superProductId = $this->getData('parent_id');
        $superProduct = new Elite_Vaf_Model_Catalog_Product();
        $superProduct->setId($superProductId);
        return $superProduct;
    }
}