<?php
class Elite_Vafwheel_Model_Catalog_ProductTest extends Elite_Vaf_TestCase
{ 
    function testCreateNewProduct()
    {
	$product = new Elite_Vaf_Model_Catalog_Product;
	$wheelProduct = new Elite_Vafwheel_Model_Catalog_Product($product);
	$this->assertFalse($wheelProduct->getBoltPatterns(), 'should create new product w/ no bolt patterns');
    }

    function testWhenNoBoltPattern()
    {
        $product = $this->newWheelProduct();
        $product->setId(1);
        $this->assertEquals( array(), $product->getBoltPatterns(), 'when product has no bolt patterns should return emtpy array' );
    }
    
    function testWhenAddingBoltShouldAddApplicableVehicleApplications()
    {
        $wheelVehicle = new Elite_Vafwheel_Model_Vehicle($this->createMMY());
        $wheelVehicle->save();
        $wheelVehicle->addBoltPattern( $this->boltPattern('4x114.3') );
        
        $wheelProduct = $this->newWheelProduct();
        $wheelProduct->setId(1);
        $wheelProduct->addBoltPattern( $this->boltPattern('4x114.3') );

        $this->assertNotEquals( 0, count($wheelProduct->getFits()), 'when adding a bolt to a product should also automatically add applicable vehicle applications' );
    }
    
    function testReadBackBoltPattern()
    {
        $product = $this->newWheelProduct();
        $product->setId(1);
        $product->addBoltPattern( $this->boltPattern('4x114.3') );
        
        $product = $this->newWheelProduct();
        $product->setId(1);
        
        $boltPatterns = $product->getBoltPatterns();
        $this->assertEquals( 4, $boltPatterns[0]->getLugCount() );
        $this->assertEquals( 114.3, $boltPatterns[0]->getDistance() );
    }
    
    function testReadBackMultipleBoltPatterns()
    {
        $product = $this->newWheelProduct();
        $product->setId(1);
        $product->addBoltPattern( $this->boltPattern('4x114.3') );
        $product->addBoltPattern( $this->boltPattern('5x114.3') );
        
        $product = $this->newWheelProduct();
        $product->setId(1);
        
        $boltPatterns = $product->getBoltPatterns();
        $this->assertEquals( 4, $boltPatterns[0]->getLugCount() );
        $this->assertEquals( 114.3, $boltPatterns[0]->getDistance() );
        
        $this->assertEquals( 5, $boltPatterns[1]->getLugCount() );
        $this->assertEquals( 114.3, $boltPatterns[1]->getDistance() );
    }

    function testShouldImport()
    {
	$data = '"sku","lug_count","bolt_distance"' . "\n";
	$data .= '"sku","4","144.3"';
        $file = TESTFILES . '/product-wheel-sizes.csv';
        file_put_contents( $file, $data );


        $this->insertProduct('sku');
	$importer = new Elite_Vafwheel_Model_Catalog_Product_ImportTests_TestSubClass($file);
	$importer->import();

	$product = $this->getProductForSku('sku');
        $product = new Elite_Vafwheel_Model_Catalog_Product($product);
        $boltPatterns = $product->getBoltPatterns();

        $this->assertEquals( 4, $boltPatterns[0]->getLugCount(), 'should set lug_count' );
        $this->assertEquals( 144.3, $boltPatterns[0]->getDistance(), 'should set bolt distance' );
    }
    
}