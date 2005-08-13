<?php
require_once 'CartController.php';
class Elite_Vaf_controllers_CartControllerTest extends Elite_Vaf_TestCase
{
    function testShouldGetGlobalConfig()
    {
        $controller = new Elite_Vaf_CartController( new Zend_Controller_Request_HttpTestCase, new Zend_Controller_Response_HttpTestCase);
        $controller->getConfig();
        $this->assertTrue(true,'should not generate error');
    }
    
    function testShouldNOTRequireVehicle()
    {
        $config = new Zend_Config( array('product'=>array('requireVehicleBeforeCart'=>'false')) );
        
        $controller = new Elite_Vaf_CartController( new Zend_Controller_Request_HttpTestCase, new Zend_Controller_Response_HttpTestCase);
        $controller->setConfig($config);
        
        $this->assertFalse( $controller->shouldShowIntermediatePage(), 'should NOT require vehicle' );
    }
    
    function testShouldRequireVehicle()
    {
        $config = new Zend_Config( array('product'=>array('requireVehicleBeforeCart'=>'true')) );
        
        $controller = new Elite_Vaf_CartController( new Zend_Controller_Request_HttpTestCase, new Zend_Controller_Response_HttpTestCase);
        $controller->setConfig($config);
        $controller->setProduct($this->productWithFitments());
        
        $this->assertTrue( $controller->shouldShowIntermediatePage(), 'should require vehicle' );
    }
    
    function productWithFitments()
    {
        $mmy = $this->createMMY();
        $this->insertProduct('test');
        $product = $this->getProductForSku('test');
        $product->addVafFit($mmy->toValueArray());
        return $product;
    }
}