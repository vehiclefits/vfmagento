<?php
class Elite_Vaf_Model_Catalog_ProductTests_ApplicationFitmentsTests_GetFitsPerformanceTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
    function doSetUp()
    {
	$this->switchSchema('year,make,model');
	$config = new Zend_Config( array('seo'=>array('rewriteProductName'=>true)));
	$this->product = $this->getProduct2($config);
        $this->add100Fitments($this->product,350);
    }
    
    function testWhen300Fitments_ShouldBeFast()
    {
        $this->setMaxRunningTime(1);

	$this->product->getFitModels();
        $this->product->getFitModels();
        $this->product->getFitModels();
        $this->product->getFitModels();
        $this->product->getFitModels();
        $this->product->getFitModels();
        $this->product->getFitModels();
    }
}