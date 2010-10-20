<?php
class Elite_Vafimporter_Model_VehiclesList_CSV_ImportTests_MMY_FieldsTest extends Elite_Vafimporter_Model_VehiclesList_CSV_TestCase
{
    protected $csvData;
    protected $csvFile;
    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        
        $this->csvData = 'make, model, year';
        $this->csvFile = TESTFILES . '/definitions-single.csv';
        file_put_contents( $this->csvFile, $this->csvData );
    }
    
    /**
    *  Elite_Vafimporter_Model_VehiclesList_CSV::getFieldPositions
    *  Elite_Vafimporter_Model
    */
    function testShouldFigureOutFieldPositions()
    {
        $importer = $this->getDefinitions( $this->csvFile );
        $this->assertEquals( array( 'make' => 0, 'model' => 1, 'year' => 2), $importer->getFieldPositions(), 'should figure out field positions' );
    }
    
    /**
    *  Elite_Vafimporter_Model_VehiclesList_CSV::getFieldPositions
    *  Elite_Vafimporter_Model
    */
    function testShouldFigureOutFieldPositions2()
    {
        $importer = $this->getDefinitions( $this->csvFile );
        $importer->getFieldPositions();
        $importer->getFieldPositions();
        $this->assertEquals( array( 'make' => 0, 'model' => 1, 'year' => 2), $importer->getFieldPositions(), 'should figure out field positions (repeatable)' );
    }
    
}