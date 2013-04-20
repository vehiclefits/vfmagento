<?php
class Elite_Vaf_Model_Catalog_ProductTests_ApplicationFitmentsTests_GetFitsTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
	const PRODUCT_ID = 1;
    const PRODUCT_NAME = 'Widget';
    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testGetFitsStartsEmpty()
    {
        $product = $this->getProduct();
        $this->assertEquals( array(), $product->getFits() );
    }
    
    function testGetFits()
    {
        $product = $this->getProduct(self::PRODUCT_ID);
        $vehicle = $this->createMMY();
        $product->addVafFit( $vehicle->toValueArray() );
        
        $actual = $product->getFits();
        $this->assertEquals( 1, count($actual) );
        $fit = $actual[0];
        $this->assertEquals( $vehicle->toValueArray(), array('make'=>$fit->make_id,'model'=>$fit->model_id,'year'=>$fit->year_id), 'should get fitment' );
    }
    
    function testIsRepeatable()
    {
        $product = $this->getProduct(self::PRODUCT_ID);
        $product->addVafFit( $this->createMMY()->toValueArray() );
        $this->assertSame( $product->getFits(), $product->getFits(), 'method call should be repeatable' );
    }
    
    function testGetFitModels()
    {
        $product = $this->getProduct(self::PRODUCT_ID);
        $vehicle = $this->createMMY();
        $product->addVafFit($vehicle->toValueArray());
        
        $actual = $product->getFitModels();
        $this->assertEquals( 1, count($actual) );
        $fit = $actual[0];
        $this->assertEquals( $vehicle->toValueArray(), $fit->toValueArray(), 'should get fitments as models' );
    }
}