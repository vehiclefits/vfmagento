<?php

class Elite_Vaflinks_Block_CMSTest extends Elite_Vaf_TestCase
{

    function testShouldDisableOutput()
    {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');
        $this->insertMappingMMY($vehicle, 1);

        $block = new Elite_Vaflinks_Block_CMSTestSub;
        $block->setConfig(new Zend_Config(array('directory' => array('cmsEnable' => false))));
        $html = $block->toHtml();
        $this->assertEquals('', $html, 'should disable output');
    }

    function testShouldShowMake()
    {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');
        $this->insertMappingMMY($vehicle, 1);

        $_GET['make'] = $vehicle->getValue('make');
        $block = new Elite_Vaflinks_Block_CMSTestSub;
        $block->setConfig(new Zend_Config(array('directory' => array('cmsEnable' => true))));
        $html = $block->toHtml();
        $this->assertEquals('The current vehicle is: Honda', $html, 'should show make');
    }

}

class Elite_Vaflinks_Block_CMSTestSub extends Elite_Vaflinks_Block_CMS
{

    function toHtml()
    {
        return $this->_toHtml();
    }

    protected function _toHtml()
    {
        if (!$this->isEnabled())
        {
            return;
        }
        ob_start();
        include(MAGE_PATH . '/app/design/frontend/default/default/template/vaflinks/cms.phtml');
        return ob_get_clean();
    }

    function htmlEscape($text)
    {
        return $text;
    }

}