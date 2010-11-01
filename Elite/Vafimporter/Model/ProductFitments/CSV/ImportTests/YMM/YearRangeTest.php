<?php
class Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_YMM_YearRangeTest extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{    
    protected function doSetUp()
    {
        $this->switchSchema( 'year,make,model' );
        
        $this->csvData = 'sku, make, model, year_start, year_end
sku, honda, civic, 2000, 2001';
        
        $this->insertProduct( self::SKU );
    }
    
    function testYear2000()
    {
        $this->FitmentsImport( $this->csvData );
        $this->assertTrue( $this->vehicleExists(array('year'=>'2000')), '' );
    }

    function testYear2001()
    {
        $this->FitmentsImport( $this->csvData );
        $this->assertTrue( $this->vehicleExists(array('year'=>'2001')), '' );
    }
     
}