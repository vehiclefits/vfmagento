<?php
class VF_Import_ProductFitments_CSV_ImportTests_MMY_LevelWildcardTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->insertProduct('sku');
    }
    
    function testShouldFindPossibleVehicles()
    {
        $this->createMMY('Ford', 'F150', '2000');
        $this->createMMY('Ford', 'F250', '2000');
        
        $importer = $this->mappingsImporterFromData('sku,make,model,year' . "\n" .
                                                    'sku,Ford,F*,2000');
        $importer->import();
        $this->assertEquals(2, $importer->getCountMappings(), 'should find possible vehicles for fitment');
    }
        
    function testShouldFindPossibleVehicles2()
    {
        $this->createMMY('Ford', 'F-150', '2000');
        $this->createMMY('Ford', 'F-150 Super Duty', '2000');
        $this->createMMY('Ford', 'F-250', '2000');
        $this->createMMY('Ford', 'F-250 Super Duty', '2000');
        
        $importer = $this->mappingsImporterFromData('sku,make,model,year' . "\n" .
                                                    'sku,Ford,F*,2000');
        $importer->import();
        $this->assertEquals(4, $importer->getCountMappings(), 'should find possible vehicles for fitment');
    }
    
    function testShouldNotAddInvalidVehicle()
    {
        $this->createMMY('Ford', 'F-150', '2000');
        $this->createMMY('Ford', 'F-150', '2001');
        $this->createMMY('Ford', 'F-250', '2001');
        
        $importer = $this->mappingsImporterFromData('sku,make,model,year' . "\n" .
                                                    'sku,Ford,F*,"2000,2001"');
        $importer->import();
        $this->assertEquals(3, $importer->getCountMappings(), 'should not add f-250 for 2000');
    }
    

}