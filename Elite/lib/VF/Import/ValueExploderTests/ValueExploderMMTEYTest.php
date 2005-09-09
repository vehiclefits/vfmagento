<?php
class VF_Import_ValueExploderMMTEYTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{
    protected function doSetUp()
    {
        $this->switchSchema('make,model,trim,engine,year');        
        
        $this->product_id = $this->insertProduct('sku');
    }
    
    function testExplodeValues()
    {
        
        $valueExploder = new VF_Import_ValueExploder;
        $this->importDefinitions();
        
        $result = $valueExploder->explode( array('make'=>'honda','model'=>'civic','trim'=>'{{all}}','engine'=>'{{all}}','year'=>2000) );
        
        $this->assertEquals( 4, count($result), 'value exploder should explode multiple tokens' );
        $this->assertEquals( array('make'=>'honda','model'=>'civic','trim'=>'ex','engine'=>'a','year'=>2000), $result[0] );
        $this->assertEquals( array('make'=>'honda','model'=>'civic','trim'=>'ex','engine'=>'b','year'=>2000), $result[1] );
        $this->assertEquals( array('make'=>'honda','model'=>'civic','trim'=>'lx','engine'=>'a','year'=>2000), $result[2] );
        $this->assertEquals( array('make'=>'honda','model'=>'civic','trim'=>'lx','engine'=>'b','year'=>2000), $result[3] );
    }

    protected function importDefinitions()
    {
        $csvData = 'make, model, trim, engine, year
honda, civic, ex, a, 2000
honda, civic, ex, b, 2000
honda, civic, lx, a, 2000
honda, civic, lx, b, 2000

honda, civic, lx, b, 2001
not honda, civic, lx, b, 2000';
        $csvFile = TESTFILES . '/definitions.csv';
        file_put_contents( $csvFile, $csvData );
        
        $importer = new VF_Import_VehiclesList_CSV_Import( $csvFile );
        $importer->import();
    }
}