<?php
class Elite_Vafsitemap_Model_Sitemap_VehicleTests_CountTest extends Elite_Vaf_TestCase
{
    protected $make, $model, $year;
    
    function doSetUp()
    {
        $this->switchSchema( 'make,model,year' );
        $this->definition = $this->createMMY();
    }

    function testWhenThereIsAMappingShouldCountTheDefinition()
    {
        $sitemap = new Elite_Vafsitemap_Model_Sitemap_Vehicle(Elite_Vaf_Helper_Data::getInstance()->getConfig());
        $this->insertMappingMMY( $this->definition );
        $this->assertEquals( 1, $sitemap->vehicleCount(), 'when there is a mapping should count the definition' );
    }

    function testWhenThereIsNotAMappingShouldNotCountTheDefinition()
    {
        $sitemap = new Elite_Vafsitemap_Model_Sitemap_Vehicle(Elite_Vaf_Helper_Data::getInstance()->getConfig());
        $this->assertEquals( 0, $sitemap->vehicleCount(), 'when there is not a mapping should not count the definition' );
    }

}