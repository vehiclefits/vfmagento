<?php
class Elite_Vaf_Model_Catalog_ProductTests_ApplicationFitmentsTests_RewriteTitlePerformanceTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
    protected $product;
    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        
        $config = new Zend_Config( array('seo'=>array('rewriteProductName'=>true)));
        $this->product = $this->getProduct2($config);
        $this->add100Fitments($this->product);
    }
    
    function testWhen300Fitments_ShouldBeFast()
    {
        $this->setMaxRunningTime(1);
        $this->product->getName();
    }
}