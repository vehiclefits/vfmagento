<?php
class Elite_Vafsitemap_Helper_SeoName
{
    function applyName( Elite_Vaf_Model_Catalog_Product $product )
    {
        if( $this->shouldApplyName() )
        {
            $product->setCurrentlySelectedFit( $this->getFit() );
        }  
    }
    
    protected function shouldApplyName()
    {
        if( !$this->rewritesOn() )
        {
            return false ;
        }        
        if( !$this->getFitId() )
        {
            return false;
        }
        return true;
    }
    
    protected function rewritesOn()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getConfig()->seo->rewriteProductName;
    }
    
    protected function getFit()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getFit();
    }
    
    protected function getFitId()
    {
        return Elite_Vaf_Helper_Data::getInstance()->getFitId();
    }
}
