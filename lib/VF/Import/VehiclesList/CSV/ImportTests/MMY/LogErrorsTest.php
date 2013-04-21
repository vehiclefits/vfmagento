<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
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