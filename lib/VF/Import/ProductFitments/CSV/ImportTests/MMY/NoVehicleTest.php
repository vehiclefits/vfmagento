<?php
class VF_Import_ProductFitments_CSV_ImportTests_MMY_NoVehicletest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->insertProduct('sku');
    }

    function testShouldNotIncrementSkippedCount()
    {
        $importer = $this->mappingsImporterFromData('sku,make,model,year' . "\n" .
                                                    'sku,,,');
        $importer->import();
        $this->assertEquals(0, $importer->getCountSkippedMappings(), 'should not increment skipped count when there is no vehicle');
    }
    
    function testShouldIncrementInvalidVehicleCount()
    {
        $importer = $this->mappingsImporterFromData('sku,make,model,year' . "\n" .
                                                    'sku,,,');
        $importer->import();
        $this->assertEquals(1, $importer->invalidVehicleCount(), 'should increment invalid vehicle count when there is no vehicle');
    }
    
    function testShouldIncrementInvalidVehicleCount2()
    {
        $importer = $this->mappingsImporterFromData('sku,make,model,year' . "\n" .
                                                    'sku,make,,year');
        $importer->import();
        $this->assertEquals(1, $importer->invalidVehicleCount(), 'should increment invalid vehicle count when there is no vehicle');
    }
    
    function testShouldNotIncrementInvalidVehicleCountForUniversal()
    {
        $importer = $this->mappingsImporterFromData('sku,make,model,year,universal' . "\n" .
                                                    'sku,,,,1');
        $importer->import();
        $this->assertEquals(0, $importer->invalidVehicleCount(), 'should not increment invalid vehicle count when universal fitment');
    }
}