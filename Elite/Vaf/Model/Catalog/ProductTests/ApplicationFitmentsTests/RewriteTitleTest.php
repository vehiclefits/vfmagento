<?php
class Elite_Vaf_Model_Catalog_ProductTests_ApplicationFitmentsTests_RewriteTitleTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{
	const PRODUCT_ID = 1;
    const PRODUCT_NAME = 'Widget';
    
    protected $vehicle;
    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->vehicle = $this->createMMY('Honda','Civic','2002');
    }
    
    function testWhenProductFitsSelection_ShouldRewriteTitle()
    {
        $config = new Zend_Config( array('seo'=>array('rewriteProductName'=>true)));
        $product = $this->getProduct2($config);
        $product->addVafFit($this->vehicle->toValueArray());
        
        $product->setCurrentlySelectedFit( $this->vehicle );
        $this->assertEquals( 'Widget for Honda Civic 2002', $product->getName(), 'when product fits selection (and rewrites enabled), should rewrite title' );
    }
    
    function testWhenProductFitsSelection_ShouldRewriteTitle2()
    {
        $config = new Zend_Config( array('seo'=>array('rewriteProductName'=>true)));
        $product = $this->getProduct2($config);
        $product->addVafFit($this->vehicle->toValueArray());
        
        $this->setRequestParams($this->vehicle->toValueArray());
        $product->setCurrentlySelectedFit( Elite_Vaf_Helper_Data::getInstance()->getFit() );
        $this->assertEquals( 'Widget for Honda Civic 2002', $product->getName(), 'when product fits selection (and rewrites enabled), should rewrite title' );
    }
    
    function testWhenProductDoesNotFitSelection_ShouldNotRewriteTitle()
    {
        $config = new Zend_Config( array('seo'=>array('rewriteProductName'=>true)));
        $product = $this->getProduct2($config);
        
        $product->setCurrentlySelectedFit( $this->vehicle );
        $this->assertEquals( 'Widget', $product->getName(), 'when product does not fit selection, should not rewrite title' );
    }
    
    function testWhenProductDoesNotFitSelection_ShouldNotRewriteTitle2()
    {
        $config = new Zend_Config( array('seo'=>array('rewriteProductName'=>true)));
        $product = $this->getProduct2($config);
        
        $this->setRequestParams($this->vehicle->toValueArray());
        $product->setCurrentlySelectedFit( Elite_Vaf_Helper_Data::getInstance()->getFit() );
        $this->assertEquals( 'Widget', $product->getName(), 'when product does not fit selection, should not rewrite title' );
    }
    
    function testWhenNotSettingCurrentlySelectedFit_ShouldNotRewritetitle()
    {
        return $this->markTestIncomplete('when not setting the currently selected fit, should not rewrite the title');
    }
    
    function testWhenRewritesDisabled_ShouldNotRewriteTitle()
    {
        $config = new Zend_Config( array('seo'=>array('rewriteProductName'=>false)));
        $product = $this->getProduct2($config);
        $product->addVafFit($this->vehicle->toValueArray());
        
        $product->setCurrentlySelectedFit( $this->vehicle );
        $this->assertEquals( 'Widget', $product->getName(), 'when rewrites disabled, should not rewrite title' );
    }
    
    function testWhenRewritesDisabled_ShouldNotRewriteTitle2()
    {
        $config = new Zend_Config( array('seo'=>array('rewriteProductName'=>false)));
        $product = $this->getProduct2($config);
        $product->addVafFit($this->vehicle->toValueArray());
        
        $this->setRequestParams($this->vehicle->toValueArray());
        $product->setCurrentlySelectedFit( Elite_Vaf_Helper_Data::getInstance()->getFit() );
        $this->assertEquals( 'Widget', $product->getName(), 'when rewrites disabled, should not rewrite title' );
    }
    
    function getProduct2($config)
    {
        $product = $this->getProduct(self::PRODUCT_ID);
        $product->setName( self::PRODUCT_NAME );
        $product->setConfig($config);
        return $product;
    }

}