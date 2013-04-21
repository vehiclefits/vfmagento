<?php
class Elite_Vaftire_Model_Catalog_Product_ImportTests_DifferentColumnOrderTest extends Elite_Vaftire_Model_Catalog_Product_ImportTests_TestCase
{    
    const SKU = 'sku';
    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->csvData = '"sku","diameter","section_width","aspect_ratio"
"sku","16","205","55"';
        $this->csvFile = TEMP_PATH . '/product-tire-sizes.csv';
        file_put_contents( $this->csvFile, $this->csvData );
        
        
        $this->insertProduct( self::SKU );
    }
    
    function testSetsDiameter()
    {
        $importer = $this->importer( $this->csvFile );
        $importer->import();
        $product = $this->getProductForSku( self::SKU );
        $product = new Elite_Vaftire_Model_Catalog_Product($product);
        $tireSize = $product->getTireSize();
        $this->assertEquals( 16, $tireSize->diameter(), 'should set diameter' );
    }
    
    function testSetsSectionWidth()
    {
        $importer = $this->importer( $this->csvFile );
        $importer->import();
        $product = $this->getProductForSku( self::SKU );
        $product = new Elite_Vaftire_Model_Catalog_Product($product);
        $tireSize = $product->getTireSize();
        $this->assertEquals( 205, $tireSize->sectionWidth(), 'should set section width' );
    }
    
    function testSetsAspectRatio()
    {
        $importer = $this->importer( $this->csvFile );
        $importer->import();
        $product = $this->getProductForSku( self::SKU );
        $product = new Elite_Vaftire_Model_Catalog_Product($product);
        $tireSize = $product->getTireSize();
        $this->assertEquals( 55, $tireSize->aspectRatio(), 'should set aspect ratio' );
    }

}