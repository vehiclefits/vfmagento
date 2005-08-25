<?php
class Elite_Vaf_Model_Catalog_ProductTests_GetMappingIdTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{

    function testMappingId()
    {
        $vehicle = $this->createMMY();
        $mapping_id = $this->insertMappingMMY( $vehicle, 1 );
        
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId( 1 );
        
        $vehicleFinder = new Elite_Vaf_Model_Vehicle_Finder( new VF_Schema() );
        $vehicle = $vehicleFinder->findByLeaf( $vehicle->getLevel('year')->getId() );
        
        $this->assertEquals( $mapping_id, $product->getMappingId( $vehicle ), 'should find the mapping id for a definition' );
    }
    
    function testMappingIdProductDifferent()
    {
        $vehicle= $this->createMMY();
        $mapping_id = $this->insertMappingMMY( $vehicle, 2 );
        
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId( 1 );
        
        $vehicleFinder = new Elite_Vaf_Model_Vehicle_Finder( new VF_Schema() );
        $vehicle = $vehicleFinder->findByLeaf( $vehicle->getLevel('year')->getId() );
        
        $this->assertEquals( null, $product->getMappingId( $vehicle ), 'should return null if a product has no mappings' );
    }

}