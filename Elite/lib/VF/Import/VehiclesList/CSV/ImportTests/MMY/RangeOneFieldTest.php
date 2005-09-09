<?php
class VF_Import_VehiclesList_CSV_ImportTests_MMY_RangeOneFieldTest extends VF_Import_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testSingleYear()
    {
        $this->importVehiclesList('make, model, year_range' . "\n" .
                                  'honda, civic, 2000');
        
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'civic', 'year'=>'2000')) );
    }
    
    function testYearRange()
    {
        $this->importVehiclesList('make, model, year_range' . "\n" .
                                  'honda, civic, 2000-2002');
        
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'civic', 'year'=>'2000')) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'civic', 'year'=>'2002')) );
    }
    
    function testShouldReverseYears()
    {
        $this->importVehiclesList('make, model, year_range' . "\n" .
                                  'honda, accord, 2006-2003');
                                  
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'2003')) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'2006')) );
    }
    
    
}
