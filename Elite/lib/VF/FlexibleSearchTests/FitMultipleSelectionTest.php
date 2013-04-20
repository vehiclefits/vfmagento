<?php
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