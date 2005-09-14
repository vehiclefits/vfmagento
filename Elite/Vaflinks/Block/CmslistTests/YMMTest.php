<?php
class Elite_Vaflinks_Block_CMSListYMMTest extends Elite_Vaf_TestCase {

    function doSetUp()
    {
        $this->switchSchema('year,make,model');
    }
    
    function testShouldListMakes()
    {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');
        $this->insertMappingMMY($vehicle, 1);

        $block = new Elite_Vaflinks_Block_CMSListTests_TestSub;
        $block->setConfig( new Zend_Config(array('directory'=>array('cmsEnable'=>true))) );
        $html = $block->toHtml();
        
        $this->assertRegExp('#<a href="/vaflinks/cms\?make=[0-9]+">Honda</a>#', $html, 'should list out makes');
    }


}