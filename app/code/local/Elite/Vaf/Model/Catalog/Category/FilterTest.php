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
class Elite_Vaf_Model_Catalog_Category_FilterImplTest extends Elite_Vaf_TestCase
{
    const ID = 3;
    const DIFFERENT_ID = 4;
    const ANY_CATEGORY = 0;
    
    /**
    *  Elite_Vaf_Model_Catalog_Category_FilterImpl
    */
    function testDoesntFilterWhenDisabled()
    {
        $filter = $this->getFilter( array( 'disable' => true ) );
        $this->assertFalse( $filter->shouldShow( self::ANY_CATEGORY ), 'If disable=true, WILL NOT filter on ANY category page' );
    }
    
    /**
    *  Elite_Vaf_Model_Catalog_Category_FilterImpl
    */
    function testShouldFilterOnAllCategoriesInAbsenseOfWhitelistOrBlacklist()
    {
        $filter = $this->getFilter(array());
        $this->assertTrue( $filter->shouldShow( self::ID ), 'Should Filter On All Categories In Absense Of Whitelist Or Blacklist ' );
    }
    
    /**
    *  Elite_Vaf_Model_Catalog_Category_FilterImpl
    */
    function testShouldFilterOnNonCategory()
    {
        $filter = $this->getFilter(array());
        $this->assertTrue( $filter->shouldShow( null ), 'Should Filter On a non category (null)' );
    }
    
    /**
    *  Elite_Vaf_Model_Catalog_Category_FilterImpl
    */
    function testBlacklistSingle()
    {
        $filter = $this->getFilter( array( 'blacklist' => self::ID ) );
        $this->assertFalse( $filter->shouldShow( self::ID ), 'If blacklist is specified and category is in blacklist, WILL NOT filter' );
    }
    
    /**
    *  Elite_Vaf_Model_Catalog_Category_FilterImpl
    */
    function testBlacklistMulti()
    {
        $filter = $this->getFilter( array( 'blacklist' => '1, 2' ) );
        $this->assertFalse( $filter->shouldShow( 2 ) );
    }
    
    /**
    *  Elite_Vaf_Model_Catalog_Category_FilterImpl
    */
    function testWhitelistMulti()
    {
        $filter = $this->getFilter( array( 'whitelist' => '1, 2' ) );
        $this->assertTrue( $filter->shouldShow( 2 ) );
    }
    
    /**
    *  Elite_Vaf_Model_Catalog_Category_FilterImpl
    */
    function testFiltersWhenInWhitelist()
    {
        $filter = $this->getFilter( array( 'whitelist' => self::ID ) );
        $this->assertTrue( $filter->shouldShow( self::ID ), 'If whitelisting is specified, and category is in whitelist, WILL filter' );
    }
    
    /**
    *  Elite_Vaf_Model_Catalog_Category_FilterImpl
    */
    function testDoesNotFilterWhenNotInWhitelist()
    {
        $filter = $this->getFilter( array( 'whitelist' => self::DIFFERENT_ID ) );
        $this->assertFalse( $filter->shouldShow( self::ID ), 'if whitelisting is specified, and category is not in whitelist, WILL NOT filter' );
    }
    
    protected function getFilter( $config )
    {
        $filter = new Elite_Vaf_Model_Catalog_Category_FilterImpl();
        $filter->setConfig( new Zend_Config( array( 'category' => $config ) ) );
        return $filter;
    }
}