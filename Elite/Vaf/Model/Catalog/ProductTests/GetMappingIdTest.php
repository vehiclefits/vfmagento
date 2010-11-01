<?php
class Elite_Vaf_Model_Catalog_ProductTests_GetFitmentIdTest extends Elite_Vaf_Model_Catalog_ProductTests_TestCase
{

    function testFitmentId()
    {
        $vehicle = $this->createMMY();
        $Fitment_id = $this->insertFitmentMMY( $vehicle, 1 );
        
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId( 1 );
        
        $vehicleFinder = new Elite_Vaf_Model_Vehicle_Finder( new Elite_Vaf_Model_Schema() );
        $vehicle = $vehicleFinder->findByLeaf( $vehicle->getLevel('year')->getId() );
        
        $this->assertEquals( $Fitment_id, $product->getFitmentId( $vehicle ), 'should find the Fitment id for a definition' );
    }
    
    function testFitmentIdProductDifferent()
    {
        $vehicle= $this->createMMY();
        $Fitment_id = $this->insertFitmentMMY( $vehicle, 2 );
        
        $product = new Elite_Vaf_Model_Catalog_Product();
        $product->setId( 1 );
        
        $vehicleFinder = new Elite_Vaf_Model_Vehicle_Finder( new Elite_Vaf_Model_Schema() );
        $vehicle = $vehicleFinder->findByLeaf( $vehicle->getLevel('year')->getId() );
        
        $this->assertEquals( null, $product->getFitmentId( $vehicle ), 'should return null if a product has no Fitments' );
    }

}