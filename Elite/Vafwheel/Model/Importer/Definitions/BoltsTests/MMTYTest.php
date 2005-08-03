<?php
class Elite_Vafwheel_Model_Importer_Definitions_BoltsTests_MMTYTest extends Elite_Vafwheel_Model_Importer_Definitions_BoltsTests_TestCase
{
    protected $csvData;
    protected $csvFile;
    
    function doSetUp()
    {
        $this->switchSchema('make,model,trim,year');
    }
    
    function testShouldImport1()
    {
	$this->import('Make,Model,Trim,Year_Start,Year_End,Bolt_Pattern
CHEVROLET,K-2500 PICKUP ,BASE,1988,2000,8X165.1');

	$vehicle = $this->vehicleFinder()->findOneByLevels(array('make'=>'CHEVROLET','model'=>'K-2500 PICKUP', 'trim'=>'BASE', 'year'=>1988));
	$vehicle = new Elite_Vafwheel_Model_Vehicle($vehicle);
        $this->assertEquals( 8, $vehicle->boltPattern()->lug_count, 'should import' );
    }
    
    function testShouldImport2()
    {
	$this->import('Make,Model,Trim,Year_Start,Year_End,Bolt_Pattern
MAZDA,PROTÉGÉ ,DX,1988,2000,8X165.1');

	$vehicle = $this->vehicleFinder()->findOneByLevels(array('make'=>'MAZDA','model'=>'PROTÉGÉ', 'trim'=>'dx', 'year'=>1990));
	$vehicle = new Elite_Vafwheel_Model_Vehicle($vehicle);
        $this->assertEquals( 8, $vehicle->boltPattern()->lug_count, 'should import' );
    }

    function testShouldImport3()
    {
	$this->import('"MAKE","MODEL","TRIM","year_start","year_end","BOLT PATTERN"
"PROTÉGÉ","2.2, 3.0 CL","base","1995","2009","4x114.3"');

	$vehicle = $this->vehicleFinder()->findOneByLevels(array('make'=>'PROTÉGÉ','model'=>'2.2', 'trim'=>'base', 'year'=>1995));
	$vehicle = new Elite_Vafwheel_Model_Vehicle($vehicle);
        $this->assertEquals( 4, $vehicle->boltPattern()->lug_count, 'should import' );
    }

    function testShouldImportUTF8()
    {
	$importer = new Elite_Vafwheel_Model_Importer_Definitions_Bolts(dirname(__FILE__).'/bolts_small-utf8.csv');
        $importer->import();

	$vehicle = $this->vehicleFinder()->findOneByLevels(array('make'=>'PROTÉGÉ','model'=>'2.2', 'trim'=>'base', 'year'=>1995));
	$vehicle = new Elite_Vafwheel_Model_Vehicle($vehicle);
        $this->assertEquals( 4, $vehicle->boltPattern()->lug_count, 'should import' );
    }

    function testShouldImportANSI()
    {
	return $this->markTestIncomplete();
	$importer = new Elite_Vafwheel_Model_Importer_Definitions_Bolts(dirname(__FILE__).'/bolts_small-ansi.csv');
        $importer->import();

	$vehicle = $this->vehicleFinder()->findOneByLevels(array('make'=>'PROTÉGÉ','model'=>'2.2', 'trim'=>'base', 'year'=>1995));
	$vehicle = new Elite_Vafwheel_Model_Vehicle($vehicle);
        $this->assertEquals( 4, $vehicle->boltPattern()->lug_count, 'should import' );
    }

    function import($data)
    {
	$this->csvData = $data;
        $this->csvFile = TESTFILES . '/bolt-definitions-range.csv';
        file_put_contents( $this->csvFile, $this->csvData );

        $importer = new Elite_Vafwheel_Model_Importer_Definitions_Bolts( $this->csvFile );
        $importer->import();
    }
}