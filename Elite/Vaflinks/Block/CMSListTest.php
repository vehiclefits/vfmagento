
<?php

class Elite_Vaflinks_Block_CMSListTest extends Elite_Vaf_TestCase {

    function testShouldDisableOutput()
    {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');
        $this->insertMappingMMY($vehicle, 1);

        $block = new Elite_Vaflinks_Block_CMSListTestSub;
        $block->setConfig( new Zend_Config(array('directory'=>array('cmsEnable'=>false))) );
        $html = $block->toHtml();
        $this->assertEquals('', $html, 'should disable output');
    }
    
    function testShouldListMakes()
    {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');
        $this->insertMappingMMY($vehicle, 1);

        $block = new Elite_Vaflinks_Block_CMSListTestSub;
        $block->setConfig( new Zend_Config(array('directory'=>array('cmsEnable'=>true))) );
        $html = $block->toHtml();
        $this->assertRegExp('#<a href="/vaflinks/cms\?make=[0-9]+">Honda</a>#', $html, 'should list out makes');
    }


}

class Elite_Vaflinks_Block_CMSListTestSub extends Elite_Vaflinks_Block_CMSList {

    function toHtml() {
        return $this->_toHtml();
    }

    protected function _toHtml() {
        if (!$this->isEnabled()) {
            return;
        }
        ob_start();
        include(ELITE_PATH . '/Vaflinks/design/frontend/default/default/template/vaflinks/cms-list.phtml');
        return ob_get_clean();
    }

    function htmlEscape($text) {
        return $text;
    }

}