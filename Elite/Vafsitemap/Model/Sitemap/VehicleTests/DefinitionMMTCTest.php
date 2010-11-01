<?php
class Elite_Vafsitemap_Model_Sitemap_VehicleTests_DefinitionMMTCTest extends Elite_Vaf_TestCase
{
    protected $make, $model, $trim, $chassis;
    
    function doSetUp()
    {
        $this->switchSchema( 'make,model,trim,chassis' );
    }

    function testDefinitions()
    {
        $sitemap = new Elite_Vafsitemap_Model_Sitemap_Vehicle;
        $vehicle = $this->createMMTC();
        $this->insertFitmentMMTC( $vehicle );

        $vehicles = $sitemap->getDefinitions();
        $this->assertTrue( $vehicles[0] instanceof Elite_Vaf_Model_Vehicle );
        $this->assertNotEquals( 0, (int)$vehicles[0]->getLevel('chassis')->getId() );
    }

}