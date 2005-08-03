<?php
class Elite_Vaf_Model_MergeTests_PaintTest extends Elite_Vaf_TestCase
{
    const NEWLINE = "\n";
    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        
        $this->csvData = 'Make,Model,Year,Code,Name,Color(hex)' . self::NEWLINE;
        $this->csvData .= 'Acura, Integra, 1986,  B-26MZ,  Avignon Blue Metallic Clearcoat, #9CBBCC' . self::NEWLINE;
        $this->csvData .= 'Acura, Integra, 1987,  B-38,  Capitol Blue, #061D72' . self::NEWLINE;
        $this->csvFile = TESTFILES . '/paint-definitions.csv';
        file_put_contents( $this->csvFile, $this->csvData );

        $importer = new Elite_Vafpaint_Model_Importer_Definitions_Paint( $this->csvFile );
        $importer->import();
    }
    
	/**
	 * @expectedException Elite_Vaf_Model_Merge_Exception_IncompatibleVehicleAttribute
	 */
	function testShouldPreventOperation()
    {
        $vehicle1 = $this->vehicleFinder()->findOneByLevels(array('make'=>'Acura', 'model'=>'Integra', 'year'=>'1986'));
        $vehicle2 = $this->vehicleFinder()->findOneByLevels(array('make'=>'Acura', 'model'=>'Integra', 'year'=>'1987'));
        
        $slaveLevels = array(
            array('year', $vehicle1 ),
            array('year', $vehicle2 ),
        );
        $masterLevel = array('year', $vehicle2 );
        
        $this->merge($slaveLevels, $masterLevel);
    }
    
	/**
	 * @expectedException Elite_Vaf_Model_Merge_Exception_IncompatibleVehicleAttribute
	 */
	function testShouldPreventOperation2()
    {
        $vehicle1 = $this->vehicleFinder()->findOneByLevels(array('make'=>'Acura', 'model'=>'Integra', 'year'=>'1986'));
        $vehicle2 = $this->createMMY();
        
        $slaveLevels = array(
            array('year', $vehicle1 ),
            array('year', $vehicle2 ),
        );
        $masterLevel = array('year', $vehicle2 );
        
        $this->merge($slaveLevels, $masterLevel);
    }
}