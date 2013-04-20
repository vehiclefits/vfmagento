<?php
class VF_Import_ProductFitments_CSV_ImportTests_MMY_AllWildcardTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    protected $product_id;
    
    protected $vehiclesList = 'make, model, year
honda, civic, 2000
honda, accord, 2000
honda, accord, 2001';
    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');        
        $this->product_id = $this->insertProduct('sku');
    }
    
    function testBlowoutSingleColumn()
    {
        $this->importVehiclesList($this->vehiclesList);
        $this->mappingsImport('sku, make, model, year
sku, honda, {{all}}, 2000');
        
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId($this->product_id);
        $fits = $product->getFits();
        
        $this->assertEquals( 2, count($fits), 'should blow out options' );
        $this->assertEquals( 'civic', $fits[0]->model );
        $this->assertEquals( 'accord', $fits[1]->model );
        
    }
        
    function testBlowoutMultipleColumn()
    {
        $this->importVehiclesList($this->vehiclesList);
        $this->mappingsImport('sku, make, model, year
sku, honda, {{all}}, {{all}}');
        
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId($this->product_id);
        $fits = $product->getFits();
        
        $this->assertEquals( 3, count($fits), 'should blow out options' );
        $this->assertEquals( 'civic', $fits[0]->model );
        
        $this->assertEquals( 'accord', $fits[1]->model );
        $this->assertEquals( '2000', $fits[1]->year );
        
        $this->assertEquals( 'accord', $fits[2]->model );
        $this->assertEquals( '2001', $fits[2]->year );
        
    }
    
}
