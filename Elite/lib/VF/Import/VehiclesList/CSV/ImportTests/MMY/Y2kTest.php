<?php
class VF_Import_VehiclesList_CSV_ImportTests_MMY_Y2kTest extends VF_Import_TestCase
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
    
    function testShouldDisableY2kMode_OneField()
    {
        $config = new Zend_Config(array('importer'=>array('Y2KMode'=>false)));
        $importer = $this->vehiclesListImporter('make, model, year_range' . "\n" .
                                  'honda, accord, 03-06');
                                  
        $importer->setConfig($config);
        $importer->import();
                                  
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'03')) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'06')) );
    }
    
    function testShouldDisableY2kMode_TwoField()
    {
        $config = new Zend_Config(array('importer'=>array('Y2KMode'=>false)));
        $importer = $this->vehiclesListImporter('make, model, year_start, year_end' . "\n" .
                                  'honda, accord, 03, 06');
                                  
        $importer->setConfig($config);
        $importer->import();
                                  
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'03')) );
        $this->assertFalse( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'2003')) );
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'06')) );
        $this->assertFalse( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'2006')) );
    }
    
    function testShouldUseCenturyThreshold_OneField()
    {
        $config = new Zend_Config(array('importer'=>array('Y2KThreshold'=>30)));
        $importer = $this->vehiclesListImporter('make, model, year_range' . "\n" .
                                  'honda, accord, 25');
                                  
        $importer->setConfig($config);
        $importer->import();
                                  
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'2025')) );
    }
    
    function testShouldUseCenturyThreshold_TwoField()
    {
        $config = new Zend_Config(array('importer'=>array('Y2KThreshold'=>30)));
        $importer = $this->vehiclesListImporter('make, model, year_start, year_end' . "\n" .
                                  'honda, accord, 25, 25');
                                  
        $importer->setConfig($config);
        $importer->import();
                                  
        $this->assertTrue( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'2025')) );
        $this->assertFalse( $this->vehicleExists(array('make'=>'honda', 'model'=>'accord', 'year'=>'25')) );
    }
}