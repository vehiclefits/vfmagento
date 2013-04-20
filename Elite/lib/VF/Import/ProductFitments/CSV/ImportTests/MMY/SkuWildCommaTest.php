<?php
class VF_Import_ProductFitments_CSV_ImportTests_MMY_SkuWildCommaTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->csvData = 'sku, make, model, year
"aaa*,bbb*", honda, civic, 2000';
        
        $this->insertProduct('aaa1');
        $this->insertProduct('aaa2');
        $this->insertProduct('bbb1');
        $this->insertProduct('bbb2');
        $this->insertProduct('ZZZ');
    }
    
    function testShouldMatchAAA1()
    {
        $this->mappingsImport($this->csvData);
        $fit = $this->getFitForSku('aaa1');
        $this->assertEquals( 'honda', $fit->getLevel('make')->getTitle() );
    }

    function testShouldMatchAAA2()
    {
        $this->mappingsImport($this->csvData);
        $fit = $this->getFitForSku('aaa1');
        $this->assertEquals( 'honda', $fit->getLevel('make')->getTitle() );
    }

    function testShouldMatchBBB1()
    {
        $this->mappingsImport($this->csvData);
        $fit = $this->getFitForSku('aaa1');
        $this->assertEquals( 'honda', $fit->getLevel('make')->getTitle() );
    }

    function testShouldMatchBBB2()
    {
        $this->mappingsImport($this->csvData);
        $fit = $this->getFitForSku('bbb2');
        $this->assertEquals( 'honda', $fit->getLevel('make')->getTitle() );
    }


  
    function testShouldNotMatchZZZ()
    {
        $this->mappingsImport($this->csvData);
        $fit = $this->getFitForSku('ZZZ');
        $this->assertFalse( $fit );
    }
    
  
}
