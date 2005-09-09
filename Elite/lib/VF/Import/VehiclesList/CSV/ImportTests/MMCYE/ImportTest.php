<?php
class VF_Import_VehiclesList_CSV_ImportTests_MMCYE_ImportTest extends VF_Import_TestCase
{
    function doSetUp()
    {
		$this->switchSchema('make,model,chassis,years,engine');
    }
    
    function testSameChassis()
    {
        $csvData = 'make,model,engine,chassis,years'; // testing with the levels not in their regular "order"
        $csvData .= "\n";
        $csvData .= 'Honda,Accord,1.6 Luxe,4-doors sedan,1985 to 1989';
        $csvData .= "\n";
        $csvData .= 'Honda,Civic,1.3 Luxe,4-doors sedan,1985 to 1989';
        
        $this->importVehiclesList($csvData);
        
        $this->assertTrue( $this->vehicleExists(array('make'=>'Honda', 'model'=>'Accord', 'engine'=>'1.6 Luxe', 'chassis'=>'4-doors sedan', 'years'=>'1985 to 1989')), 'imports vehicle 1');
        $this->assertTrue( $this->vehicleExists(array('make'=>'Honda', 'model'=>'Civic', 'engine'=>'1.3 Luxe', 'chassis'=>'4-doors sedan', 'years'=>'1985 to 1989')), 'imports vehicle 2');
    }

}