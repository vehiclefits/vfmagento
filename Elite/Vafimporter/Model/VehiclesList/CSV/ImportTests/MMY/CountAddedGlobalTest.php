<?php
class Elite_Vafimporter_Model_VehiclesList_CSV_ImportTests_MMY_CountAddedGlobalTest extends Elite_Vafimporter_TestCase
{    
    function doSetUp()
    {
        $schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
        $schemaGenerator->dropExistingTables();
        $schemaGenerator->execute(array(
            'year',
            'make' => array('global'=>true),
            'model'
        ));
        $this->startTransaction();
    }
    
    function doTearDown()
    {
        $schemaGenerator = new Elite_Vaf_Model_Schema_Generator();
        $schemaGenerator->dropExistingTables();
    }
    
    function testShouldAddTwoModels()
    {
        $importer = $this->importVehiclesList('make, model, year' . "\n" .
                                              'honda, integra, 2000' . "\n" .
                                              'acura, integra, 2000');
                                              
        $this->assertEquals( 2, $importer->getCountAddedByLevel('model'), 'should add two models' );
    }
    
    function testShouldAddYear()
    {
        $importer = $this->importVehiclesList('make, model, year' . "\n" .
                                              'acura, integra, 2000');
                                              
        $this->assertEquals( 1, $importer->getCountAddedByLevel('year'), 'should add year' );
    }
    
    function testShouldCountUniqueYears()
    {
        $importer = $this->importVehiclesList('make, model, year' . "\n" .
                                              'honda, civic, 2000' . "\n" .
                                              'acura, integra, 2000');
                                              
        $this->assertEquals( 1, $importer->getCountAddedByLevel('year'), 'should count unique years' );
    }
    
    function testShouldCountVehiclesAdded()
    {
        $importer = $this->importVehiclesList('make, model, year' . "\n" .
                                              'honda, civic, 2000' . "\n" .
                                              'acura, integra, 2000');
                                              
        $this->assertEquals( 2, $importer->getCountAddedVehicles(), 'should count added vehicles' );
    }
    
    function testShouldCount0Added()
    {
        $importer = $this->importVehiclesListTwice('make, model, year' . "\n" .
                                              'honda, civic, 2000' . "\n" .
                                              'acura, integra, 2000');
                                              
        $this->assertEquals( 0, $importer->getCountAddedVehicles(), 'should count 0 added (should not count something we already had)' );
    }
    
}