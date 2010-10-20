<?php
class Elite_Vafimporter_Model_ValueExploderMMYTest extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');        
        
        $this->product_id = $this->insertProduct('sku');
    }
    
    function testExplodeValues()
    {
        
        $valueExploder = new Elite_Vafimporter_Model_ValueExploder;
        $this->importDefinitions();
        
        $result = $valueExploder->explode( array('make'=>'honda','model'=>'{{all}}','year'=>2000) );
        
        $this->assertEquals( 2, count($result), 'value exploder should explode single token' );
        $this->assertEquals( array('make'=>'honda','model'=>'civic','year'=>2000), $result[0] );
        $this->assertEquals( array('make'=>'honda','model'=>'accord','year'=>2000), $result[1] );
    }
    
    function testExplodeValuesMultiple()
    {
        
        $valueExploder = new Elite_Vafimporter_Model_ValueExploder;
        $this->importDefinitions();
        
        $result = $valueExploder->explode( array('make'=>'honda','model'=>'{{all}}','year'=>'{{all}}') );
        
        $this->assertEquals( 3, count($result), 'value exploder should explode multiple tokens' );
        $this->assertEquals( array('make'=>'honda','model'=>'civic','year'=>2000), $result[0] );
        $this->assertEquals( array('make'=>'honda','model'=>'civic','year'=>2001), $result[1] );
        $this->assertEquals( array('make'=>'honda','model'=>'accord','year'=>2000), $result[2] );
    }
    
    protected function importDefinitions()
    {
        $csvData = 'make, model, year
honda, civic, 2000
honda, accord, 2000
honda, civic, 2001.
not honda, whatev, 2000';
        $csvFile = TESTFILES . '/definitions.csv';
        file_put_contents( $csvFile, $csvData );
        
        $importer = $this->getDefinitionsCsv( $csvFile );
        $importer->import();
    }
}