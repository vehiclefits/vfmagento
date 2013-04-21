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
class VF_FlexibleSearchTests_FitMultipleSelectionTest extends Elite_Vaf_Helper_DataTestCase
{
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldDetectNumericRequest()
    {
        $civic2000 = $this->createMMY('Honda','Civic','2000');
        $civic2001 = $this->createMMY('Honda','Civic','2001');
       
        $requestParams = array(
            'make' => $civic2000->getValue('make'),
            'model' => $civic2000->getValue('model'),
            'year_start' => $civic2000->getValue('year'),
            'year_end' => $civic2001->getValue('year')
        );
        $helper = $this->getHelper( array(), $requestParams );
        $this->assertTrue( $helper->flexibleSearch()->isNumericRequest());
    }
    
    function testShouldHaveMake()
    {
        $civic2000 = $this->createMMY('Honda','Civic','2000');
        $civic2001 = $this->createMMY('Honda','Civic','2001');
       
        $requestParams = array(
            'make' => $civic2000->getValue('make'),
            'model' => $civic2000->getValue('model'),
            'year_start' => $civic2000->getValue('year'),
            'year_end' => $civic2001->getValue('year')
        );
        $helper = $this->getHelper( array(), $requestParams );
        $this->assertEquals($civic2000->getValue('make'), $helper->flexibleSearch()->getValueForSelectedLevel('make'));
    }
    
    function testShouldFitInsideRange()
    {
        $civic2000 = $this->createMMY('Honda','Civic','2000');
        $civic2001 = $this->createMMY('Honda','Civic','2001');
       
        $requestParams = array(
            'make' => $civic2000->getValue('make'),
            'model' => $civic2000->getValue('model'),
            'year_start' => $civic2000->getValue('year'),
            'year_end' => $civic2001->getValue('year')
        );
        $helper = $this->getHelper( array(), $requestParams );
        $this->assertTrue( $helper->vehicleSelection()->contains($civic2000) );
        $this->assertTrue( $helper->vehicleSelection()->contains($civic2001) );
    }
    
    function testShouldNotFitOutsideRange()
    {
        $civic2000 = $this->createMMY('Honda','Civic','2000');
        $civic2001 = $this->createMMY('Honda','Civic','2001');
       
        $requestParams = array(
            'make' => $civic2000->getValue('make'),
            'model' => $civic2000->getValue('model'),
            'year_start' => $civic2001->getValue('year'),
            'year_end' => $civic2001->getValue('year')
        );
        $helper = $this->getHelper( array(), $requestParams );
        
        $this->assertFalse( $helper->vehicleSelection()->contains($civic2000) );
    }
    
    function testShouldStoreInSession()
    {
        $_SESSION = array('make'=>null, 'model'=>null, 'year'=>null, 'year_start'=>null, 'year_end'=>null);
        
        $civic2000 = $this->createMMY('Honda','Civic','2000');
        $civic2001 = $this->createMMY('Honda','Civic','2001');
        
        $requestParams = array(
            'make' => $civic2000->getValue('make'),
            'model' => $civic2000->getValue('model'),
            'year_start' => $civic2000->getValue('year'),
            'year_end' => $civic2001->getValue('year')
        );
        $helper = $this->getHelper( array(), $requestParams );
        $helper->storeFitInSession();
        unset($_SESSION['garage']);
        $this->assertNull( $_SESSION['year'], 'should store vehicle in session' );
        $this->assertEquals( $civic2000->getValue('year'), $_SESSION['year_start'], 'should store vehicle in session' );
        $this->assertEquals( $civic2001->getValue('year'), $_SESSION['year_end'], 'should store vehicle in session' );
    }

}