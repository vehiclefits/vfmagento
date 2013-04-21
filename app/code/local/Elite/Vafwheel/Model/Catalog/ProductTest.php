<?php
class Elite_Vafwheel_Model_Catalog_ProductTest extends Elite_Vaf_TestCase
{ 
    function testCreateNewProduct()
    {
	$product = new Elite_Vaf_Model_Catalog_Product;
	$wheelProduct = new Elite_Vafwheel_Model_Catalog_Product($product);
	$this->assertEquals( array(), $wheelProduct->getBoltPatterns(), 'should create new product w/ no bolt patterns');
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
    
    function testShouldIncludeOEOffset()
    {
        $wheelVehicle = new Elite_Vafwheel_Model_Vehicle($this->createMMY());
        $wheelVehicle->save();
        $wheelVehicle->addBoltPattern( $this->boltPattern('4x114.3', 15) );
        
        $wheelProduct = $this->newWheelProduct();
        $wheelProduct->setId(1);
        $wheelProduct->addBoltPattern( $this->boltPattern('4x114.3', 20) );

        $this->assertNotEquals( 0, count($wheelProduct->getFits()), 'should include if OE offset is within threshold' );
    }
    
    function testShouldExcludeOEOffset()
    {
        $wheelVehicle = new Elite_Vafwheel_Model_Vehicle($this->createMMY());
        $wheelVehicle->save();
        $wheelVehicle->addBoltPattern( $this->boltPattern('4x114.3', 15) );
        
        $wheelProduct = $this->newWheelProduct();
        $wheelProduct->setId(1);
        $wheelProduct->addBoltPattern( $this->boltPattern('4x114.3', 21) );

        $this->assertEquals( 0, count($wheelProduct->getFits()), 'should exclude if OE offset is within threshold' );
    }
    
    function testWhenNoOffset()
    {
        $wheelVehicle = new Elite_Vafwheel_Model_Vehicle($this->createMMY());
        $wheelVehicle->save();
        $wheelVehicle->addBoltPattern( $this->boltPattern('4x114.3', 15) );
        
        $wheelProduct = $this->newWheelProduct();
        $wheelProduct->setId(1);
        $wheelProduct->addBoltPattern( $this->boltPattern('4x114.3') );

        $this->assertNotEquals( 0, count($wheelProduct->getFits()), 'should always add fitment if wheel has no offset specified' );
    }
    
    function testReadBackBoltPattern()
    {
        $product = $this->newWheelProduct();
        $product->setId(1);
        $product->addBoltPattern( $this->boltPattern('4x114.3', 20) );
        
        $product = $this->newWheelProduct();
        $product->setId(1);
        
        $boltPatterns = $product->getBoltPatterns();
        $this->assertEquals( 4, $boltPatterns[0]->getLugCount() );
        $this->assertEquals( 114.3, $boltPatterns[0]->getDistance() );
        $this->assertEquals( 20, $boltPatterns[0]->getOffset() );
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
        $file = TEMP_PATH . '/product-wheel-sizes.csv';
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
    
    function testShouldAddWhenOffsetFits()
    {
        $wheelVehicle = new Elite_Vafwheel_Model_Vehicle($this->createMMY());
        $wheelVehicle->save();
        $wheelVehicle->addBoltPattern( $this->boltPattern('4x114.3', 38.5) );
        
        $wheelProduct = $this->newWheelProduct();
        $wheelProduct->setId(1);
        $wheelProduct->addBoltPattern( $this->boltPattern('4x114.3', 38.5) );

        $this->assertEquals( 1, count($wheelProduct->getFits()), 'should add when offset matches' );
    }
    
    function testShouldNotAddWhenOffsetDoesntFit()
    {
        $wheelVehicle = new Elite_Vafwheel_Model_Vehicle($this->createMMY());
        $wheelVehicle->save();
        $wheelVehicle->addBoltPattern( $this->boltPattern('4x114.3', 20) );
        
        $wheelProduct = $this->newWheelProduct();
        $wheelProduct->setId(1);
        $wheelProduct->addBoltPattern( $this->boltPattern('4x114.3', 42) );

        $this->assertEquals( 0, count($wheelProduct->getFits()), 'should not add when offset does not matche' );
    }
    
}