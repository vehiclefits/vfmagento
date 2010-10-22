<?php
class Elite_Vafimporter_Model_VehiclesList_CSV_ImportTests_MMY_CountTest extends Elite_Vafimporter_Model_VehiclesList_CSV_TestCase
{    
    const MAKES = 2;
    const MODELS = 3;
    const YEARS = 11;

    protected $csvData;

    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->csvData = 'make, model, year
honda, civic, 2000
honda, civic, 2001
honda, civic, 2002
honda, accord, 2003
honda, accord, 2004
honda, accord, 2005
honda, accord, 2006
acura, integra, 2000
acura, integra, 2001
acura, integra, 2002
acura, integra, 2003';
    }
    
    function testCountAddedDefaults0()
    {
        $importer = $this->import( $this->csvData );
        $this->assertEquals( 0, $importer->getCountAddedByLevel('foobar'), 'countAdded should always return 0, even if the level was not part of the imported data' );
    }
    
    function testWhenImportingWillAddMakes()
    {
        $importer = $this->import( $this->csvData );
        $this->assertEquals( self::MAKES, $importer->getCountAddedByLevel('make'), 'When importing Makes not yet import, WILL count them as added' );
    }

    function testWhenImportingWillAddModels()
    {
        $importer = $this->import( $this->csvData );
        $this->assertEquals( self::MODELS, $importer->getCountAddedByLevel('model'), 'When importing Models not yet import, WILL count them as added' );
    }
    
    function testWhenImportingWillAddYears()
    {
        $importer = $this->import( $this->csvData );
        $this->assertEquals( self::YEARS, $importer->getCountAddedByLevel('year'), 'When importing Years not yet import, WILL count them as added' );
    }
    
    function testWhenNoMakesWillAdd0()
    {
        $importer = $this->importTwice( $this->csvData );
        $this->assertEquals( 0, $importer->getCountAddedByLevel('make'), 'Importing data we already have WILL NOT count the Make as added' );
    }
    
    function testWhenNoModelsWillAdd0()
    {
        $importer = $this->importTwice( $this->csvData );
        $this->assertEquals( 0, $importer->getCountAddedByLevel('model'), 'Importing data we already have WILL NOT count the Model as added' );
    }
    
    function testWhenNoYearsWillAdd0()
    {
        $importer = $this->importTwice( $this->csvData );
        $this->assertEquals( 0, $importer->getCountAddedByLevel('year'), 'Importing data we already have WILL NOT count the Year as added' );
    }
    
    protected function importTwice( $file )
    {
        $this->import( $file );
        return $this->import( $file );
    }
    
    protected function import( $data)
    {
        $importer = $this->vehiclesListImporter( $data );
        $importer->import();
        return $importer;
    }
       
}