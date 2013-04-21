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

class Elite_Vaflinks_Block_ListTest extends Elite_Vaf_TestCase {

    function testShouldListMakes() {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');
        $this->insertMappingMMY($vehicle, 1);

        $block = new Elite_Vaflinks_Block_ListTestSub;
        $html = $block->toHtml();
        $this->assertRegExp('#<a href="\?make=[0-9]+&model=0&year=0">Honda</a>#', $html, 'should list out makes');
    }

    function testShouldListMakes_BaseUrl() {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');
        $this->insertMappingMMY($vehicle, 1);

        $request = $this->getRequest();
        $request->setBasePath('/foo/');

        $block = new Elite_Vaflinks_Block_ListTestSub;
        $block->setRequest($request);
        $html = $block->toHtml();
        $this->assertRegExp('#<a href="\?make=[0-9]+&model=0&year=0">Honda</a>#', $html, 'should use base path');
    }

    function testShouldListMakes_RequestUri() {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');
        $this->insertMappingMMY($vehicle, 1);

        $request = $this->getRequest();
        $request->setBasePath('/foo');
        $request->setRequestUri('/bar');

        $block = new Elite_Vaflinks_Block_ListTestSub;
        $block->setRequest($request);
        $html = $block->toHtml();
        $this->assertRegExp('#<a href="\?make=[0-9]+&model=0&year=0">Honda</a>#', $html, 'should use request uri');
    }

    function testShouldListModels() {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');
        $this->insertMappingMMY($vehicle, 1);

        $block = new Elite_Vaflinks_Block_ListTestSub;
        $request = $this->getRequest(array('make' => $vehicle->getValue('make')));
        $this->setRequest($request);
        $block->setRequest($request);
        $html = $block->toHtml();
        $this->assertRegExp('#<a href="\?make=[0-9]+&model=[0-9]+&year=0">Honda Civic</a>#', $html, 'should list out models');
    }

    function testShouldListYears() {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');
        $this->insertMappingMMY($vehicle, 1);

        $block = new Elite_Vaflinks_Block_ListTestSub;
        $request = $this->getRequest(array('make' => $vehicle->getValue('make'), 'model' => $vehicle->getValue('model')));
        $this->setRequest($request);
        $block->setRequest($request);
        $html = $block->toHtml();
        $this->assertRegExp('#<a href="/vaf/product/list\?make=[0-9]+&model=[0-9]+&year=[0-9]+">Honda Civic 2000</a>#', $html, 'should list out years');
    }

    function testShouldListYearsAfterListingModel() {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');
        $this->insertMappingMMY($vehicle, 1);

        // list models
        $block = new Elite_Vaflinks_Block_ListTestSub;
        $request = $this->getRequest(array('make' => $vehicle->getValue('make')));
        $this->setRequest($request);
        $block->setRequest($request);
        $html = $block->toHtml();

        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();

        // list years
        $block = new Elite_Vaflinks_Block_ListTestSub;

        $request = $this->getRequest(array('make' => $vehicle->getValue('make'), 'model' => $vehicle->getValue('model')));
        $this->setRequest($request);
        $block->setRequest($request);

        $html = $block->toHtml();
        $this->assertRegExp('#<a href="/vaf/product/list\?make=[0-9]+&model=[0-9]+&year=[0-9]+">Honda Civic 2000</a>#', $html, 'should list out years after listing models');
    }

    function testShouldListYearsAfterListingModel_BasePath() {
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');
        $this->insertMappingMMY($vehicle, 1);

        // list models
        $block = new Elite_Vaflinks_Block_ListTestSub;
        $request = $this->getRequest(array('make' => $vehicle->getValue('make')));
        $this->setRequest($request);
        $block->setRequest($request);
        $html = $block->toHtml();

        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();

        // list years
        $block = new Elite_Vaflinks_Block_ListTestSub;

        $request = $this->getRequest(array('make' => $vehicle->getValue('make'), 'model' => $vehicle->getValue('model')));
        $request->setBasePath('/foo/');
        $this->setRequest($request);
        $block->setRequest($request);

        $html = $block->toHtml();
        $this->assertRegExp('#<a href="/foo/vaf/product/list\?make=[0-9]+&model=[0-9]+&year=[0-9]+">Honda Civic 2000</a>#', $html, 'should use base path');
    }

}

class Elite_Vaflinks_Block_ListTestSub extends Elite_Vaflinks_Block_List {

    function toHtml() {
        return $this->_toHtml();
    }

    function _toHtml() {
        ob_start();
        include(MAGE_PATH . '/app/design/frontend/default/default/template/vf/vaflinks/list.phtml');
        return ob_get_clean();
    }

    function htmlEscape($text) {
        return $text;
    }

}