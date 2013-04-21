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
class Elite_Vaf_Helper_DataTest_DataConfigTest extends Elite_Vaf_Helper_DataTestCase
{
    function testGetConfigSearch()
    {
        $config = $this->getHelper()->getConfig();
        $this->assertTrue( $config->search instanceof Zend_Config, 'search section should exist in default configuration' );
    }
    
    function testGetConfigCategory()
    {
        $config = $this->getHelper()->getConfig();
        $this->assertTrue( $config->category instanceof Zend_Config, 'category section should exist in default configuration' );
    }    
    
    function testGetConfigDirectory()
    {
        $config = $this->getHelper()->getConfig();
        $this->assertTrue( $config->directory instanceof Zend_Config, 'directory section should exist in default configuration' );
    }
    
    function testGetConfigHomepageSearch()
    {
        $config = $this->getHelper()->getConfig();
        $this->assertTrue( $config->homepagesearch instanceof Zend_Config, 'homepagesearch section should exist in default configuration' );
    }
    
    function testGetConfigCategoryChooser()
    {
        $config = $this->getHelper()->getConfig();
        $this->assertTrue( $config->categorychooser instanceof Zend_Config, 'categorychooser section should exist in default configuration' );
    }
    
    function testGetConfigMyGarage()
    {
        $config = $this->getHelper()->getConfig();
        $this->assertTrue( $config->mygarage instanceof Zend_Config, 'mygarage section should exist in default configuration' );
    }
    
    function testGetConfigSeo()
    {
        $config = $this->getHelper()->getConfig();
        $this->assertTrue( $config->seo instanceof Zend_Config, 'seo section should exist in default configuration' );
    }
    
    function testGetConfigProduct()
    {
        $config = $this->getHelper()->getConfig();
        $this->assertTrue( $config->product instanceof Zend_Config, 'product section should exist in default configuration' );
    }
    
    function testGetConfigLogos()
    {
        $config = $this->getHelper()->getConfig();
        $this->assertTrue( $config->logo instanceof Zend_Config, 'logo section should exist in default configuration' );
    }

    function testGetConfigImporter()
    {
        $config = $this->getHelper()->getConfig();
        $this->assertTrue( $config->importer instanceof Zend_Config, 'importer section should exist in default configuration' );
    }

    function testGetConfigTire()
    {
        $config = $this->getHelper()->getConfig();
        $this->assertTrue( $config->tire instanceof Zend_Config, 'tire section should exist in default configuration' );
    }

}