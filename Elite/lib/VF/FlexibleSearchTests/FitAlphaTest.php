<?php
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
}