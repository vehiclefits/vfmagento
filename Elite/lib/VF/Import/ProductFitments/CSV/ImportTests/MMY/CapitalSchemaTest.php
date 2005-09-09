<?php
class Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_MMY_CapitalSchemaTest extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{
    protected function doSetUp()
    {
        $this->switchSchema('Make,Model,Year');
        $this->csvData = 'sku, Make, Model, Year
sku, honda, civic, 2000';

        $this->insertProduct( self::SKU );
    }

    function testSku()
    {
        $this->mappingsImport($this->csvData);
        $fit = $this->getFitForSku( self::SKU );
        $this->assertEquals( 'honda', $fit->getLevel( 'Make' )->getTitle() );

	$this->schemaGenerator()->dropExistingTables();
    }
}