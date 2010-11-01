<?php
class Elite_Vafsitemap_Model_Sitemap_VehicleTests_CountTest extends Elite_Vaf_TestCase
{
    protected $make, $model, $year;
    
    function doSetUp()
    {
        $this->switchSchema( 'make,model,year' );
        $this->definition = $this->createMMY();
    }

    function testWhenThereIsAFitmentShouldCountTheDefinition()
    {
        $sitemap = new Elite_Vafsitemap_Model_Sitemap_Vehicle();
        $this->insertFitmentMMY( $this->definition );
        $this->assertEquals( 1, $sitemap->vehicleCount(), 'when there is a Fitment should count the definition' );
    }

    function testWhenThereIsNotAFitmentShouldNotCountTheDefinition()
    {
        $sitemap = new Elite_Vafsitemap_Model_Sitemap_Vehicle;
        $this->assertEquals( 0, $sitemap->vehicleCount(), 'when there is not a Fitment should not count the definition' );
    }

}