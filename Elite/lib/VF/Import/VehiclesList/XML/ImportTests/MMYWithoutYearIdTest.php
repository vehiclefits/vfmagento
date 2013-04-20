<?php
class VF_Import_VehiclesList_XML_ImportTests_MMYWithoutYearIdTest extends VF_Import_VehiclesList_XML_TestCase
{
    protected $csvData;
    protected $csvFile;

    function doSetUp()
    {
        $this->csvData = '<?xml version="1.0" encoding="UTF-8"?>   
<vehicles>
    <definition id="1">
        <make id="4">Honda</make>
        <model id="5">Civic</model>
        <year>2000</year>
    </definition>        
</vehicles>';
        $this->csvFile = TESTFILES . '/definitions.xml';
        file_put_contents( $this->csvFile, $this->csvData );
        
        $this->switchSchema('make,model,year');
    }
    
    function testDoesntImportBlank()
    {
        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();
        $this->assertFalse( $this->vehicleExists(array('make'=>'')), 'should not import a blank make' );
    }
    
    function testImportsMakeTitle()
    {
        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();
        $this->assertTrue( $this->vehicleExists(array('make'=>'Honda')), 'should import a make title' );
    }
    
    function testImportsModelTitle()
    {
        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();
        $this->assertTrue( $this->vehicleExists(array('model'=>'Civic')), 'should import a model title' );
    }
    
    function testImportsYearTitle()
    {
        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();
        $this->assertTrue( $this->vehicleExists(array('year'=>'2000')), 'should import a year title' );
    }
    
    function testImportsMakeId()
    {
        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();
        $this->assertEquals( 4, $this->levelFinder()->find('make',4)->getId(), 'imports the makeID #' );
    }
    
    function testImportsModelId()
    {
        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();
        $this->assertEquals( 5, $this->levelFinder()->find('model',5)->getId(), 'imports the modelID #' );
    }

}