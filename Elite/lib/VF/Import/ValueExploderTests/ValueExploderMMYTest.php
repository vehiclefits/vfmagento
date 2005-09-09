<?php
class VF_Import_ValueExploderMMYTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');        
        
        $this->product_id = $this->insertProduct('sku');
    }
    
    function testExplodeValues()
    {
        
        $valueExploder = new VF_Import_ValueExploder;
        $this->importDefinitions();
        
        $result = $valueExploder->explode( array('make'=>'honda','model'=>'{{all}}','year'=>2000) );
        
        $this->assertEquals( 2, count($result), 'value exploder should explode single token' );
        $this->assertEquals( array('make'=>'honda','model'=>'civic','year'=>2000), $result[0] );
        $this->assertEquals( array('make'=>'honda','model'=>'accord','year'=>2000), $result[1] );
    }
    
    function testExplodeValuesMultiple()
    {
        
        $valueExploder = new VF_Import_ValueExploder;
        $this->importDefinitions();
        
        $result = $valueExploder->explode( array('make'=>'honda','model'=>'{{all}}','year'=>'{{all}}') );
        
        $this->assertEquals( 3, count($result), 'value exploder should explode multiple tokens' );
        $this->assertEquals( array('make'=>'honda','model'=>'civic','year'=>2000), $result[0] );
        $this->assertEquals( array('make'=>'honda','model'=>'civic','year'=>2001), $result[1] );
        $this->assertEquals( array('make'=>'honda','model'=>'accord','year'=>2000), $result[2] );
    }
    
    protected function importDefinitions()
    {
        $importer = $this->vehiclesListImporter( 'make, model, year
honda, civic, 2000
honda, accord, 2000
honda, civic, 2001.
not honda, whatev, 2000' );
        $importer->import();
    }
}