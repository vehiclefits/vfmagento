<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

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
        include(MAGE_PATH . '/app/design/frontend/default/default/template/vf/vaflinks/cms.phtml');
        return ob_get_clean();
    }

    function htmlEscape($text)
    {
        return $text;
    }

}