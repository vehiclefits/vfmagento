<?php
class VF_Import_VehiclesList_XML_ExportTests_EngineTest extends VF_Import_VehiclesList_XML_TestCase
{
    protected $csvData;
    protected $csvFile;

    function doSetUp()
    {
        $this->csvData = '<?xml version="1.0" encoding="UTF-8"?>   
<vehicles version="1.0">
    <definition>
        <year id="8">2000</year>
        <make id="4">Honda</make>
        <model id="5">Civic</model>
        <submodel id="16">EX</submodel>
        <engine id="85">EX</engine>
    </definition>        
</vehicles>';
        $this->csvFile = TESTFILES . '/definitions.xml';
        file_put_contents( $this->csvFile, $this->csvData );
        
        $this->switchSchema('year,make,model,submodel,engine');
        
        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();
    }
    
    function testImportsMakeTitle()
    {
        $exporter = new VF_Import_VehiclesList_XML_Export;
                   
        $this->assertEquals( '<?xml version="1.0"?>
<vehicles version="1.0">
    <definition>
        <year id="8">2000</year>
        <make id="4">Honda</make>
        <model id="5">Civic</model>
        <submodel id="16">EX</submodel>
        <engine id="85">EX</engine>
    </definition>
</vehicles>', $exporter->export() );
    }
    
    /** @todo testIfIdIsNotAvailable */
    function testIfIdIsNotAvailable()
    {
        return $this->markTestIncomplete();
    }
    
}
