<?php
class Elite_Vafsitemap_Model_Sitemap_VehicleTests_DefinitionMMYTest extends Elite_Vaf_TestCase
{
    protected $make, $model, $year;
    
    function doSetUp()
    {
        $this->switchSchema( 'make,model,year' );
        $this->definition = $this->createMMY();
        $this->insertMappingMMY( $this->definition );
    }
    
    function testDefinitionsMMY()
    {
        $sitemap = new Elite_Vafsitemap_Model_Sitemap_Vehicle(Elite_Vaf_Helper_Data::getInstance()->getConfig());
        $vehicles = $sitemap->getDefinitions(10);
        $this->assertTrue( $vehicles[0] instanceof Elite_Vaf_Model_Vehicle );
        $this->assertNotEquals( 0, (int)$vehicles[0]->getLevel('year')->getId() );
    }

}
