<?php
class Elite_Vafsitemap_Model_Sitemap_Product_GoogleBaseTest extends Elite_Vaf_TestCase
{
	protected $make, $model, $year;
    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->definition = $this->createMMY();
        $this->insertMappingMMY( $this->definition );
    }
    
    function testDefinitionsMMY()
    {
        return $this->markTestIncomplete();
        /*
        $sitemap = new Elite_Vafsitemap_Model_Sitemap_Product_GoogleBase;
        $csv = $sitemap->csv();
//        var_dump( $csv);
        */
        
    }
}