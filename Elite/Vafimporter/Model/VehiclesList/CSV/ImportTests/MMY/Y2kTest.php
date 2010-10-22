<?php
class Elite_Vafimporter_Model_VehiclesList_CSV_ImportTests_MMY_Y2kTest extends Elite_Vafimporter_Model_VehiclesList_CSV_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testYearRange2Digit()
    {
        $this->importVehiclesList('make, model, year_range' . "\n" .
                                  'honda, accord, 03-06');
                                  
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'2003')) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'2006')) );
    }
    
    function testShouldReverseYears()
    {
        $this->importVehiclesList('make, model, year_range' . "\n" .
                                  'honda, accord, 06-03');
                                  
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'2003')) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'2006')) );
    }
    
    function testShouldDisableY2kMode()
    {
        return $this->markTestIncomplete();
        $this->importVehiclesList('make, model, year_range' . "\n" .
                                  'honda, accord, 06-03');
                                  
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'2003')) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'2006')) );
    }
}