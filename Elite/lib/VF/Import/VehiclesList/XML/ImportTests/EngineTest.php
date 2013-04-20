<?php
class VF_Import_VehiclesList_XML_ImportTests_EngineTest extends VF_Import_VehiclesList_XML_TestCase
{
    protected $csvData;
    protected $csvFile;

    function doSetUp()
    {
        $this->csvData = '<?xml version="1.0" encoding="UTF-8"?>   
<vehicles>
    <definition id="1">
        <year id="8">2000</year>
        <make id="4">Honda</make>
        <model id="5">Civic</model>
        <submodel id="5">EX</submodel>
        <engine id="5">4 Cylinder</engine>
    </definition>        
</vehicles>';
        $this->csvFile = TESTFILES . '/definitions.xml';
        file_put_contents( $this->csvFile, $this->csvData );
        
        $this->switchSchema('year,make,model,submodel,engine');
    }
    
    function testDoesntImportBlank()
    {
        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();
        $this->assertFalse( $this->vehicleExists(array('make'=>'')), 'should not import a blank make' );
    }

    function testImportsYearTitle()
    {
        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();
        $this->assertTrue( $this->vehicleExists(array('year'=>'2000')), 'should import a year title' );
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
    
    function testImportsSubmodelTitle()
    {
        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();
        $this->assertTrue( $this->vehicleExists(array('submodel'=>'EX')), 'should import a submodel title' );
    }
    
    function testImportsEngineTitle()
    {
        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();
        $this->assertTrue( $this->vehicleExists(array('engine'=>'4 Cylinder')), 'should import a engine title' );
    }
    
    
//    function testImportsMakeId()
//    {
//        $importer = $this->vehiclesListImporter( $this->csvFile );
//        $importer->import();
//        $level = new VF_Level('make',4);
//        $this->assertTrue( $level->getTitle() == 'Honda', 'imports the makeID #' );
//    }
//    
//    function testImportsModelId()
//    {
//        $importer = $this->vehiclesListImporter( $this->csvFile );
//        $importer->import();
//        $level = new VF_Level('model',5);
//        $this->assertTrue( $level->getTitle() == 'Civic', 'imports the modelID #' );
//    }
//    
//        
//    function testImportsYearId()
//    {
//        $importer = $this->vehiclesListImporter( $this->csvFile );
//        $importer->import();
//        $level = new VF_Level('year',8);
//        $this->assertTrue( $level->getTitle() == '2000', 'imports the yearID #' );
//    }

}