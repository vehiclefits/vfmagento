<?php
class Elite_Vaf_Model_Catalog_CategoryTests_CategoryTest extends Elite_Vaf_TestCase
{
  
    function testGetsProductionConfig()
    {
        $category = new Elite_Vaf_Model_Catalog_Category(); // should instantiate obj directly (so no configuration is yet set)
        $category->getProductCollection();
        $this->assertTrue( $category->getConfig() instanceof Zend_Config, 'during production it gets the config object statically' );
    }
    
}