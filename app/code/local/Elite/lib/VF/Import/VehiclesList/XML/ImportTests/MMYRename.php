<?php
class VF_Import_VehiclesList_XML_ImportTests_MMYRenameTest extends VF_Import_VehiclesList_XML_TestCase
{
    protected $csvData;
    protected $csvFile;

    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        
        
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

        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();  
        
           
              
        $this->csvData = '<?xml version="1.0" encoding="UTF-8"?>   
<vehicles>
    <definition id="1">
        <make id="4">HondaRENAMED</make>
        <model id="5">Civic</model>
        <year id="8">2000</year>
    </definition>        
</vehicles>';
        $this->csvFile = TESTFILES . '/definitions.xml';
        file_put_contents( $this->csvFile, $this->csvData );

        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();
    }
    
    function testRenames()
    {
        
        $this->assertFalse( $this->entityTitleExists( 'make', 'Honda' ), 'should be able to rename a make' );
        $this->assertTrue( $this->entityTitleExists( 'make', 'HondaRENAMED' ), 'should be able to rename a make' );
    }
    
}