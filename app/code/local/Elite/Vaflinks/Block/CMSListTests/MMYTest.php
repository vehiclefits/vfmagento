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
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Elite_Vaflinks_Block_CMSListTest extends Elite_TestCase {

    function testShouldDisableOutput()
    {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');
        $this->insertMappingMMY($vehicle, 1);

        $block = new Elite_Vaflinks_Block_CMSListTests_TestSub;
        $block->setConfig( new Zend_Config(array('directory'=>array('cmsEnable'=>false))) );
        $html = $block->toHtml();
        $this->assertEquals('', $html, 'should disable output');
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

    function testShouldNotListModels()
    {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');
        $this->insertMappingMMY($vehicle, 1);

        $_GET['make'] = $vehicle->getValue('make');
        $block = new Elite_Vaflinks_Block_CMSListTests_TestSub;
        $block->setConfig( new Zend_Config(array('directory'=>array('cmsEnable'=>true))) );
        $html = $block->toHtml();
        $this->assertRegExp('#<a href="/vaflinks/cms\?make=[0-9]+#', $html, 'should NOT list out models');
    }

}