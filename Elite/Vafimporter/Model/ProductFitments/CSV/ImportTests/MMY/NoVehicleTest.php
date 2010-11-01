<?php
class Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_MMY_NoVehicleest extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->insertProduct('sku');
    }

    function testShouldNotIncrementSkippedCount()
    {
        $importer = $this->FitmentsImporterFromData('sku,make,model,year' . "\n" .
                                                    'sku,,,');
        $importer->import();
        $this->assertEquals(0, $importer->getCountSkippedFitments(), 'should not increment skipped count');
    }
    
    function testShouldIncrementInvalidVehicleCount()
    {
        $importer = $this->FitmentsImporterFromData('sku,make,model,year' . "\n" .
                                                    'sku,,,');
        $importer->import();
        $this->assertEquals(1, $importer->invalidVehicleCount(), 'should increment invalid vehicle count');
    }
}