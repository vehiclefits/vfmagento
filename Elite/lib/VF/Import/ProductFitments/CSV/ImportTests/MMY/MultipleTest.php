<?php
class VF_Import_ProductFitments_CSV_ImportTests_MMY_MultipleTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    protected $product_id;
    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->csvData = 'sku, make, model, year_start, year_end
sku, honda, civic, 2000, 2001';
        
        $this->product_id = $this->insertProduct('sku');
    }
    
    
    function test1()
    {
        $this->mappingsImport($this->csvData);
        $params = array('make'=>'honda', 'model'=>'civic', 'year' => '2000');
        $vehicle = $this->vehicleFinder()->findOneByLevels($params);
        $product = $this->newProduct($this->product_id);
        $product->setCurrentlySelectedFit($vehicle);
        $this->assertTrue( $product->fitsSelection() );
    }

    function test2()
    {
        $this->mappingsImport($this->csvData);
        $params = array('make'=>'honda', 'model'=>'civic', 'year' => '2001');
        $vehicle = $this->vehicleFinder()->findOneByLevels($params);
        $product = $this->newProduct($this->product_id);
        $product->setCurrentlySelectedFit($vehicle);
        $this->assertTrue( $product->fitsSelection() );
    }
    
    function testShouldInsertOneMake()
    {
        $this->mappingsImport($this->csvData);
        $count = $this->getReadAdapter()->query('select count(*) from elite_level_1_make')->fetchColumn();
        $this->assertEquals(1, $count);
    }
    
    function testMultiple()
    {
        $this->insertProduct('sku1');
        $this->insertProduct('sku2');
        
        $this->mappingsImport('sku, make, model, year_start, year_end' . "\n" .
                               'sku1, honda, civic, 2000' .  "\n" .
                               'sku2, honda, civic, 2000');
        $count = $this->getReadAdapter()->query('select count(*) from elite_1_mapping')->fetchColumn();
        $this->assertEquals(2, $count);
    }
    
    function testMultiple2()
    {
        $this->insertProduct('sku1');
        $this->insertProduct('sku2');
        
        $this->mappingsImport('sku, make, model, year_start, year_end' . "\n" .
                               'sku1, honda, civic, 2000, 2001' .  "\n" .
                               'sku2, honda, integra, 2000, 2001');
        $count = $this->getReadAdapter()->query('select count(*) from elite_1_mapping')->fetchColumn();
        $this->assertEquals(4, $count);
    }

}