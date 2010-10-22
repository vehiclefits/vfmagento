<?php
class Elite_Vafimporter_Model_VehiclesList_CSV_ImportTests_MMY_LogTest extends Elite_Vafimporter_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldLogEachVehicle()
    {
        $importer = $this->vehiclesListImporter('make,model,year' . "\n" . 
                                                'honda,civic,2000');
        
        $writer = new Zend_Log_Writer_Mock();
        $logger = new Zend_Log($writer);
        
        $importer->setLog($logger);
        
        $importer->import();
        
        $event = $writer->events[0];
        $this->assertEquals( 'Vehicle added: honda civic 2000', $event['message'] );
        $this->assertEquals( Zend_Log::INFO, $event['priority'] );
    }
    
    function testShouldNotLogPrevioluslyExistingVehicles()
    {
        return $this->markTestIncomplete();
    }
}