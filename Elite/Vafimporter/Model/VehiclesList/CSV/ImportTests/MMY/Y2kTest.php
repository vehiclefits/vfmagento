<?php
class Elite_Vafimporter_Model_VehiclesList_CSV_ImportTests_MMY_Y2kTest extends Elite_Vafimporter_TestCase
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
        $config = new Zend_Config(array('importer'=>array('Y2KMode'=>true)));
        $importer = $this->vehiclesListImporter('make, model, year_range' . "\n" .
                                  'honda, accord, 06-03');
                                  
        $importer->setConfig($config);
        $importer->import();
                                  
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'2003')) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'2006')) );
    }
    
    function testShouldDisableY2kMode()
    {
        $config = new Zend_Config(array('importer'=>array('Y2KMode'=>false)));
        $importer = $this->vehiclesListImporter('make, model, year_range' . "\n" .
                                  'honda, accord, 03-06');
                                  
        $importer->setConfig($config);
        $importer->import();
                                  
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'03')) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'06')) );
    }
}