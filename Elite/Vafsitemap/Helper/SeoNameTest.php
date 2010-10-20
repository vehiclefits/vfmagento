<?php
class Elite_Vafsitemap_Helper_SeoNameTest extends Elite_Vaf_TestCase
{
    function test1()
    {
        $vehicle = $this->createMMY();
        $helper = new Elite_Vafsitemap_Helper_SeoName_TestSub( $vehicle->getLevel('year')->getId() );
        $product = new Elite_Vaf_Model_Catalog_Product;
        echo $helper->applyName( $product );
    }
}

class Elite_Vafsitemap_Helper_SeoName_TestSub extends Elite_Vafsitemap_Helper_SeoName
{
    protected $year;
    
    function __construct( $year )
    {
        $this->year = $year;
    }
    
    protected function shouldApplyName()
    {
        return true;
    }
    
    protected function getFitId()
    {
        return $this->year;
    }
}