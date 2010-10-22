<?php
class Elite_Vafimporter_Model_VehiclesList_CSV_ImportTests_MMY_LogErrorsTest extends Elite_Vafimporter_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testShouldLogInvalidYear_OneFieldRange()
    {
        $importer = $this->vehiclesListImporter('make,model,year_range' . "\n" . 
                                                'honda,civic,foo');
        
        $writer = new Zend_Log_Writer_Mock();
        $logger = new Zend_Log($writer);
        
        $importer->setLog($logger);
        
        $importer->import();
        
        $event = $writer->events[0];
        $this->assertEquals( 'Line(1) Invalid Year Range: [foo]', $event['message'] );
        $this->assertEquals( Zend_Log::NOTICE, $event['priority'] );
    }
    
    function testShouldLogInvalidYear_TwoFieldRange()
    {
        return $this->markTestIncomplete();
      //  $importer = $this->vehiclesListImporter('make,model,year_start,year_end' . "\n" . 
//                                                'honda,civic,foo,2000');
//        
//        $writer = new Zend_Log_Writer_Mock();
//        $logger = new Zend_Log($writer);
//        
//        $importer->setLog($logger);
//        
//        $importer->import();
//        
//        $event = $writer->events[0];
//        $this->assertEquals( 'Invalid Year: [foo]', $event['message'] );
//        $this->assertEquals( Zend_Log::NOTICE, $event['priority'] );
    }
    
    function testShouldNotLogPrevioluslyExistingVehicles()
    {
        return $this->markTestIncomplete();
    }
}