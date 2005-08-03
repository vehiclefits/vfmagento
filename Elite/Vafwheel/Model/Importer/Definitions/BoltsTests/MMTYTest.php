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

    function import($data)
    {
	$this->csvData = $data;
        $this->csvFile = TESTFILES . '/bolt-definitions-range.csv';
        file_put_contents( $this->csvFile, $this->csvData );

        $importer = new Elite_Vafwheel_Model_Importer_Definitions_Bolts( $this->csvFile );
        $importer->import();
    }
}