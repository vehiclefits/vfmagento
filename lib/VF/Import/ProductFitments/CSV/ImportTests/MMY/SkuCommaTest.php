<?php
class VF_Import_ProductFitments_CSV_ImportTests_MMY_SkuCommaTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->csvData = 'sku, make, model, year
"sku1,sku2", honda, civic, 2000';
        
        $this->insertProduct('sku1');
        $this->insertProduct('sku2');
        $this->insertProduct('ZZZ');
    }
    
    function testShouldMatchSku1()
    {
        $this->mappingsImport($this->csvData);
        $fit = $this->getFitForSku('sku1');
        $this->assertEquals( 'honda', $fit->getLevel('make')->getTitle() );
    }
    
    function testShouldMatchSku2()
    {
        $this->mappingsImport($this->csvData);
        $fit = $this->getFitForSku('sku2');
        $this->assertEquals( 'honda', $fit->getLevel('make')->getTitle() );
    }
    
  
    function testShouldNotMatchZZZ()
    {
        $this->mappingsImport($this->csvData);
        $fit = $this->getFitForSku('ZZZ');
        $this->assertFalse( $fit );
    }
    
  
}
