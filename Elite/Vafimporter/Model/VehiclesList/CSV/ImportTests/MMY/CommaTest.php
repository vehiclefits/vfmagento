<?php
class Elite_Vafimporter_Model_VehiclesList_CSV_ImportTests_MMY_CommaTest extends Elite_Vafimporter_Model_VehiclesList_CSV_TestCase
{    
    protected $product_id;
    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');        
    }
    
    function testComma()
    {
        $this->importDefinitions();
        $vehicleFinder = new Elite_Vaf_Model_Vehicle_Finder( new Elite_Vaf_Model_Schema );
        $vehicles = $vehicleFinder->findByLevels( array('make'=>'honda') );
                              
        $this->assertEquals( 4, count($vehicles), 'should enumerate out options' );
        $this->assertEquals( 'honda accord 2000', $vehicles[0]->__toString() );
        $this->assertEquals( 'honda accord 2003', $vehicles[1]->__toString() );        
        $this->assertEquals( 'honda civic 2000', $vehicles[2]->__toString() );        
        $this->assertEquals( 'honda civic 2003', $vehicles[3]->__toString() );        
    }
  
    protected function importDefinitions()
    {
        $importer = $this->vehiclesListImporter('"make", "model", "year"
"honda", "accord,civic", "2000,2003"');
        $importer->import();
    }
    
    
}