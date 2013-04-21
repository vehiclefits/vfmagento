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
class VF_FlexibleSearchTests_FitAlphaTest extends Elite_Vaf_Helper_DataTestCase
{
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldDetectAlnumRequest()
    {
        $vehicle = $this->createMMY('Honda','Civic','2000');
        $helper = $this->getHelper( array(), array(
                'make'=>'Honda',
                'model'=>'Civic',
                'year'=>'2000'
        ) );
        $this->assertFalse($helper->flexibleSearch()->isNumericRequest());
    }
    
    function testPassMakeByTitle()
    {
        $vehicle = $this->createMMY('Honda','Civic','2000');
        $helper = $this->getHelper( array(), array(
                'make'=>'Honda',
                'model'=>'Civic',
                'year'=>'2000'
        ) );
        $this->assertEquals( $vehicle->getLevel('make')->getId(), $helper->vehicleSelection()->getValue('make') );
    }
    
    function testPassModelByTitle()
    {
        $vehicle = $this->createMMY('Honda','Civic','2000');
        $helper = $this->getHelper( array(), array(
                'make'=>'Honda',
                'model'=>'Civic',
                'year'=>'2000'
        ) );
        $this->assertEquals( $vehicle->getLevel('model')->getId(), $helper->vehicleSelection()->getValue('model') );
    }
    
    function testPassYearByTitle()
    {
        $vehicle = $this->createMMY('Honda','Civic','2000');
        $helper = $this->getHelper( array(), array(
                'make'=>'Honda',
                'model'=>'Civic',
                'year'=>'2000'
        ) );
        $this->assertEquals( $vehicle->getLevel('year')->getId(), $helper->vehicleSelection()->getValue('year') );
    }
    
    function testGetProductIDs()
    {
        $vehicle1 = $this->createMMY('Honda', 'Civic', '2000');
        $this->insertMappingMMY($vehicle1, 1);
        
        $this->setRequestParams($vehicle1->toTitleArray());
        $this->assertEquals( array(1), Elite_Vaf_Helper_Data::getInstance()->getProductIds() );
    }
    
    function testGetProductIDsWithSpace()
    {
        $vehicle2 = $this->createMMY('Ford', 'F 150', '2000');
        $this->insertMappingMMY($vehicle2, 2);
        
        $this->setRequestParams($vehicle2->toTitleArray());
        $this->assertEquals( array(2), Elite_Vaf_Helper_Data::getInstance()->getProductIds() );
    }
    
    function testShouldStoreInSession()
    {
        $_SESSION = array('make'=>null, 'model'=>null, 'year'=>null);
        $vehicle = $this->createMMY('Honda','Civic','2000');
        $helper = $this->getHelper( array(), $vehicle->toTitleArray() );
        $helper->storeFitInSession();
        unset($_SESSION['garage']);
        $this->assertEquals( $vehicle->toValueArray(), $_SESSION, 'should store vehicle in session' );
    }
}