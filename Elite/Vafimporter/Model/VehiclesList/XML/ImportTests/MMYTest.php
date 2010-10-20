<?php
class Elite_Vafimporter_Model_VehiclesList_XML_ImportTests_MMYTest extends Elite_Vafimporter_Model_VehiclesList_XML_TestCase
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
        <year id="8">2000</year>
    </definition>        
</vehicles>';
        $this->csvFile = TESTFILES . '/definitions.xml';
        file_put_contents( $this->csvFile, $this->csvData );
        
        $this->switchSchema('make,model,year');
    }
    
    function testDoesntImportBlank()
    {
        $importer = $this->getDefinitions( $this->csvFile );
        $importer->import();
        $this->assertFalse( $this->vehicleExists(array('make'=>'')), 'should not import a blank make' );
    }
    
    function testImportsMakeTitle()
    {
        $importer = $this->getDefinitions( $this->csvFile );
        $importer->import();
        $this->assertTrue( $this->vehicleExists(array('make'=>'Honda')), 'should import a make title' );
    }
    
    function testImportsModelTitle()
    {
        $importer = $this->getDefinitions( $this->csvFile );
        $importer->import();
        $this->assertTrue( $this->vehicleExists(array('model'=>'Civic')), 'should import a model title' );
    }
    
    function testImportsYearTitle()
    {
        $importer = $this->getDefinitions( $this->csvFile );
        $importer->import();
        $this->assertTrue( $this->vehicleExists(array('year'=>'2000')), 'should import a year title' );
    }
    
    function testImportsMakeId()
    {
        $importer = $this->getDefinitions( $this->csvFile );
        $importer->import();
        $this->assertEquals( 4, $this->levelFinder()->find('make',4)->getId(), 'imports the makeID #' );
    }
    
    function testImportsModelId()
    {
        $importer = $this->getDefinitions( $this->csvFile );
        $importer->import();
        $this->assertEquals( 5, $this->levelFinder()->find('model',5)->getId(), 'imports the modelID #' );
    }
    
    function testImportsYearId()
    {
        $importer = $this->getDefinitions( $this->csvFile );
        $importer->import();
        $this->assertEquals( 8, $this->levelFinder()->find('year',8)->getId(), 'imports the yearID #' );
    }
    
    function testBlah()
    {
        $importer = $this->getDefinitionsData('<?xml version="1.0" encoding="UTF-8"?>   
<vehicles>
    <definition id="31737">
        <make id="72">FMC</make>
        <model id="9576">HPSC-156 (PEAS)</model>
        <trim id="12712">Base</trim>
        <year>1994</year>
    </definition>
</vehicles>');
        $importer->import();
    }

}