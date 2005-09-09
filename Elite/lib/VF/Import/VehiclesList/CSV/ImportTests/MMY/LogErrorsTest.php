<?php
class VF_Import_VehiclesList_CSV_ImportTests_MMY_LogErrorsTest extends VF_Import_TestCase
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
        $logger->addFilter(new Zend_Log_Filter_Priority(Zend_Log::NOTICE));
        $importer->setLog($logger);
        
        $importer->import();
        
        $event = $writer->events[0];
        $this->assertEquals( 'Line(1) Invalid Year Range: [foo]', $event['message'] );
        $this->assertEquals( Zend_Log::NOTICE, $event['priority'] );
        $this->assertEquals(0, $importer->getCountAddedVehicles());
        $this->assertEquals(0, $importer->getCountAddedByLevel('make'));
        $this->assertEquals(0, $importer->getCountAddedByLevel('year'));
        $this->assertEquals(0, $importer->getCountAddedByLevel('model'));
    }
    
    function testShouldLogInvalidYear_TwoFieldRange()
    {
        $importer = $this->vehiclesListImporter('make,model,year_start,year_end' . "\n" . 
                                                'honda,civic,foo,bar');
        
        $writer = new Zend_Log_Writer_Mock();
        $logger = new Zend_Log($writer);
        $logger->addFilter(new Zend_Log_Filter_Priority(Zend_Log::NOTICE));
        $importer->setLog($logger);
        
        $importer->import();
        
        $event = $writer->events[0];
        $this->assertEquals( 'Line(1) Invalid Year Range: [foo] & [bar]', $event['message'] );
        $this->assertEquals( Zend_Log::NOTICE, $event['priority'] );
        $this->assertEquals(0, $importer->getCountAddedVehicles());
        $this->assertEquals(0, $importer->getCountAddedByLevel('make'));
        $this->assertEquals(0, $importer->getCountAddedByLevel('year'));
        $this->assertEquals(0, $importer->getCountAddedByLevel('model'));
    }

    function testShouldLogBlankModel()
    {
        $importer = $this->vehiclesListImporter('make,model,year' . "\n" . 
                                                'honda,,2000');
        
        $writer = new Zend_Log_Writer_Mock();
        $logger = new Zend_Log($writer);
        $logger->addFilter(new Zend_Log_Filter_Priority(Zend_Log::NOTICE));
        $importer->setLog($logger);
        
        $importer->import();
        
        $event = $writer->events[0];
        $this->assertEquals( 'Line(1) Blank Model', $event['message'] );
        $this->assertEquals( Zend_Log::NOTICE, $event['priority'] );
        $this->assertEquals(0, $importer->getCountAddedVehicles());
        $this->assertEquals(0, $importer->getCountAddedByLevel('make'));
        $this->assertEquals(0, $importer->getCountAddedByLevel('year'));
        $this->assertEquals(0, $importer->getCountAddedByLevel('model'));
    }
    
    function testShouldLogCorrectLineNumber()
    {
        $importer = $this->vehiclesListImporter('make,model,year' . "\n" . 
                                                'honda,civic,2000' . "\n" .
                                                'honda,,2000');
        
        $writer = new Zend_Log_Writer_Mock();
        $logger = new Zend_Log($writer);
        $logger->addFilter(new Zend_Log_Filter_Priority(Zend_Log::NOTICE));
        $importer->setLog($logger);
        
        $importer->import();
        
        $event = $writer->events[0];
        $this->assertEquals( 'Line(2) Blank Model', $event['message'] );
    }

}