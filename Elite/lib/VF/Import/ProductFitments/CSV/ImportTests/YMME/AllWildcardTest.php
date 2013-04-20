<?php
class VF_Import_ProductFitments_CSV_ImportTests_YMME_AllWildcardTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    protected $product_id;
    
    protected function doSetUp()
    {
        $this->switchSchema('year,make,model,engine');        
        $this->product_id = $this->insertProduct('sku');
    }
    
    function testShouldMakeSafeOperations()
    {
        $this->createVehicle(array('year'=>2000, 'make'=>'Ford', 'model'=>'F-150', 'engine'=>'1.6L'));
        $this->createVehicle(array('year'=>2000, 'make'=>'Ford', 'model'=>'F-150', 'engine'=>'1.8L'));
        
        $this->createVehicle(array('year'=>2001, 'make'=>'Ford', 'model'=>'F-150', 'engine'=>'1.6L'));
        // there is no 2001/Ford/F-150 with a 1.8L in this example
        
        $this->mappingsImport('sku, make, model, year, engine' . "\n" .
                              'sku,Ford,F-150,"2000,2001,2002",{{all}}');
        
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId($this->product_id);
        $fits = $product->getFits();
        
        $this->assertEquals( 3, count($fits), 'should not a non-existant vehicle even it is implied' );
    }
        

}
