<?php

class Elite_Vaf_Model_SplitTests_PaintTest extends Elite_Vaf_TestCase
{
    const NEWLINE = "\n";

    function doSetUp()
    {
	$this->switchSchema('make,model,year');

	$this->csvData = 'make,model,year,Code,Name,Color(hex)' . self::NEWLINE;
	$this->csvData .= 'Acura, Integra, 1987,  B-38,  Capitol Blue, #061D72' . self::NEWLINE;
	$this->csvFile = TESTFILES . '/paint-definitions.csv';
	file_put_contents($this->csvFile, $this->csvData);

	$importer = new Elite_Vafpaint_Model_Importer_Definitions_Paint($this->csvFile);
	$importer->import();
    }

    /**
     * @expectedException Elite_Vaf_Model_Merge_Exception_IncompatibleVehicleAttribute
     */
    function testShouldDuplicatePaintCode()
    {
	$vehicle = $this->vehicleFinder()->findOneByLevels(array('make' => 'Acura', 'model' => 'Integra', 'year' => '1987'));
	$this->split($vehicle, 'year', array('2000', '2001'));
    }

}