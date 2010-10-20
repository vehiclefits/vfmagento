<?php
class Elite_Vaf_Model_Catalog_ProductTests_ApplicationFitmentsTests_RewriteTitlePerformanceTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
    const PRODUCT_ID = 1;
    const PRODUCT_NAME = 'Widget';
    
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
    
    function getProduct2($config)
    {
        $product = $this->getProduct(self::PRODUCT_ID);
        $product->setName( self::PRODUCT_NAME );
        $product->setConfig($config);
        return $product;
    }
    
    function add100Fitments($product)
    {
        for($i=1; $i<=100; $i++)
        {
            $vehicle = $this->createMMY('Honda'.$i,'Civic'.$i,$i);
            $product->addVafFit($vehicle->toValueArray());
        }
        
        $this->setRequestParams($vehicle->toValueArray());
        $product->setCurrentlySelectedFit( $vehicle);
    }
}