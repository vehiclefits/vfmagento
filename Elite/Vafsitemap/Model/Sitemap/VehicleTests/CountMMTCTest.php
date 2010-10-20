<?php
class Elite_Vafsitemap_Model_Sitemap_VehicleTests_CountMMTCTest extends Elite_Vaf_TestCase
{
    protected $make, $model, $trim, $chassis;
    
    function doSetUp()
    {
        $this->switchSchema( 'make,model,trim,chassis' );
    }
    
    function testCount0()
    {
        $sitemap = new Elite_Vafsitemap_Model_Sitemap_Vehicle;
        $this->assertEquals( 0, $sitemap->vehicleCount() );
    }

    function testCount1()
    {
        $sitemap = new Elite_Vafsitemap_Model_Sitemap_Vehicle;
        $vehicle = $this->createMMTC();
        $this->insertMappingMMTC( $vehicle );
        $this->assertEquals( 1, $sitemap->vehicleCount() );
    }

}