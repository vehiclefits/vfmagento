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
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Elite_Vaf_Model_Catalog_ProductTests_ApplicationFitmentsTests_GlobalRewriteTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
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
        $config = new Zend_Config( array('seo'=>array('rewriteProductName'=>true, 'globalRewrites'=>true)));
        $product = $this->getProduct2($config);
        $product->addVafFit($this->vehicle->toValueArray());
        $this->setRequestParams($this->vehicle->toValueArray());
        $this->assertEquals( 'Widget for Honda Civic 2002', $product->getName(), 'when product fits selection (and rewrites enabled), should rewrite title' );
    }
    
    
    function testWhenGlobalRewritesOff_ShouldRewriteTitle()
    {
        $config = new Zend_Config( array('seo'=>array('rewriteProductName'=>true, 'globalRewrites'=>false)));
        $product = $this->getProduct2($config);
        $product->addVafFit($this->vehicle->toValueArray());
        $product->setCurrentlySelectedFit($this->vehicle);
        
        $this->assertEquals( 'Widget for Honda Civic 2002', $product->getName(), 'when product fits selection (and rewrites enabled), should rewrite title' );
    }
    
    function testWhenProductDoesNotFitSelection_ShouldNotRewriteTitle()
    {
        $config = new Zend_Config( array('seo'=>array('rewriteProductName'=>true, 'globalRewrites'=>true)));
        $product = $this->getProduct2($config);
        $this->setRequestParams($this->vehicle->toValueArray());
        $this->assertEquals( 'Widget', $product->getName(), 'when product does not fit selection, should not rewrite title' );
    }
    
    function testWhenRewritesDisabled_ShouldNotRewriteTitle()
    {
        $config = new Zend_Config( array('seo'=>array('rewriteProductName'=>false, 'globalRewrites'=>true)));
        $product = $this->getProduct2($config);
        $product->addVafFit($this->vehicle->toValueArray());
        $this->setRequestParams($this->vehicle->toValueArray());
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