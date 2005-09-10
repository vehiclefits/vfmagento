<?php
class Elite_Vaftire_Model_Catalog_Product_ExportTest extends Elite_Vaf_TestCase
{
	function testExportHeaders()
	{
	    $tireSize = new Elite_Vaftire_Model_TireSize(205, 55, 16);

	    $id = $this->insertProduct( 'sku123' );

	    $product = $this->newTireProduct();
	    $product->setId($id);
	    $product->setTireSize($tireSize);

	    //$stream = fopen("php://temp", 'w');
	    $export = new Elite_Vaftire_Model_Catalog_Product_ExportTestSub;
//	    $export->export($stream);
	    $csv = $export->export();

	    //rewind($stream);

	    //$data = stream_get_contents($stream);

	    $expected = '"sku","section_width","aspect_ratio","diameter"
"sku123","205","55","16"
';

	    $this->assertEquals( $expected, $csv );
	}
}

class Elite_Vaftire_Model_Catalog_Product_ExportTestSub extends Elite_Vaftire_Model_Catalog_Product_Export
{
    function getProductTable()
    {
	return 'test_catalog_product_entity';
    }
}