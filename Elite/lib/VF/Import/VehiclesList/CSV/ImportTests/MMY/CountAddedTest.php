<?php
class VF_Import_VehiclesList_CSV_ImportTests_MMY_CountAddedTest extends VF_Import_TestCase
{    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testCountAddedDefaults0()
    {
        $importer = $this->importVehiclesList('make, model, year' . "\n" .
                                              'honda, civic, 2000');
                                              
        $this->assertEquals( 0, $importer->getCountAddedByLevel('foobar'), 'countAdded should always return 0, even if the level was not part of the imported data' );
    }
    
    function testShouldAddMake()
    {
        $importer = $this->importVehiclesList('make, model, year' . "\n" .
                                              'acura, integra, 2000');
                                              
        $this->assertEquals( 1, $importer->getCountAddedByLevel('make'), 'should add make' );
    }
    
    function testShouldCountUniqueMakes()
    {
        $importer = $this->importVehiclesList('make, model, year' . "\n" .
                                              'acura, integra, 2000' . "\n" .
                                              'acura, integra, 2001');
                                              
        $this->assertEquals( 1, $importer->getCountAddedByLevel('make'), 'should count unique makes' );
    }
    
    function testShouldAddTwoMakes()
    {
        $importer = $this->importVehiclesList('make, model, year' . "\n" .
                                              'honda, civic, 2000' . "\n" .
                                              'acura, integra, 2000');
                                              
        $this->assertEquals( 2, $importer->getCountAddedByLevel('make'), 'should add two makes' );
    }

    function testShouldAddModels()
    {
        $importer = $this->importVehiclesList('make, model, year' . "\n" .
                                              'acura, integra, 2000');
                                              
        $this->assertEquals( 1, $importer->getCountAddedByLevel('model'), 'should add model' );
    }
    
    function testShouldAddTwoModels()
    {
        $importer = $this->importVehiclesList('make, model, year' . "\n" .
                                              'honda, civic, 2000' . "\n" .
                                              'acura, integra, 2000');
                                              
        $this->assertEquals( 2, $importer->getCountAddedByLevel('model'), 'should add two models' );
    }
    
    function testShouldAddYear()
    {
        $importer = $this->importVehiclesList('make, model, year' . "\n" .
                                              'acura, integra, 2000');
                                              
        $this->assertEquals( 1, $importer->getCountAddedByLevel('year'), 'should add year' );
    }
    
    function testShouldAddTwoYears()
    {
        $importer = $this->importVehiclesList('make, model, year' . "\n" .
                                              'honda, civic, 2000' . "\n" .
                                              'acura, integra, 2000');
                                              
        $this->assertEquals( 2, $importer->getCountAddedByLevel('year'), 'should add two years' );
    }
    
    function testWhenNoMakesWillAdd0()
    {
        $importer = $this->importVehiclesListTwice( 'make, model, year' . "\n" .
                                        'acura, integra, 2000' );
                                        
        $this->assertEquals( 0, $importer->getCountAddedByLevel('make'), 'Importing data we already have WILL NOT count the Make as added' );
    }
    
    function testWhenNoModelsWillAdd0()
    {
        $importer = $this->importVehiclesListTwice( 'make, model, year' . "\n" .
                                        'acura, integra, 2000' );
                                        
        $this->assertEquals( 0, $importer->getCountAddedByLevel('model'), 'Importing data we already have WILL NOT count the Model as added' );
    }
    
    function testWhenNoYearsWillAdd0()
    {
        $importer = $this->importVehiclesListTwice( 'make, model, year' . "\n" .
                                        'acura, integra, 2000' );
                                        
        $this->assertEquals( 0, $importer->getCountAddedByLevel('year'), 'Importing data we already have WILL NOT count the Year as added' );
    }
    
}