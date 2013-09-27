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
class Elite_Vaf_Block_SearchTests_Search_WhiteBlackListTest extends Elite_Vaf_Block_SearchTestCase
{
    
    const ID = 3;

    function testWhenHomepageWillNoFilterByCategory()
    {
        $block = new Elite_Vaf_Block_Search();
        $this->assertTrue( $block->categoryEnabled( 0 ), 'on the homepage, or "category 0", categoryEnable WILL return true' );   
    }
    
    function testWhenFilterIsFalseWillReturnFalse()
    {
        $block = new Elite_Vaf_Block_Search();
        $block->setFilter( $this->getMockFilterThatShouldReturn( false ) );
        
        $this->assertFalse( $block->categoryEnabled( self::ID ), 'if the filter returns FALSE, WILL return FALSE' );
        $this->assertEquals( self::ID, $block->getFilter()->argumentWas(), 'the search block will call the filter with the correct category id' );
    }
    
    function testWhenFilterIsFalseWillReturnTrue()
    {
        $block = new Elite_Vaf_Block_Search();
        $block->setFilter( $this->getMockFilterThatShouldReturn( true ) );
        
        $this->assertTrue( $block->categoryEnabled( self::ID ), 'if the filter returns TRUE, WILL return TRUE' );
        $this->assertEquals( self::ID, $block->getFilter()->argumentWas(), 'the search block will call the filter with the correct category id' );
    }
    
    function testWhenFilterIsTrueWillShow()
    {
        return $this->markTestIncomplete();
        $block = new Elite_Vaf_Block_Search();
        $block->setFilter( $this->getMockFilterThatShouldReturn( true ) );
        
        $this->assertTrue( $block->categoryEnabled() );
        $this->assertEquals( self::ID, $block->getFilter()->argumentWas(), 'the search block will call the filter with the correct category id' );
    }
    
    protected function getMockFilterThatShouldReturn( $bool )
    {
        $filter = new Filter_Stub();
        $filter->willReturn( $bool );
        return $filter;
    }

}

class Filter_Stub implements Elite_Vaf_Model_Catalog_Category_Filter
{
    protected $willReturn;
    protected $argumentWas;

    /**
    * If whitelisting is ON, and category is in whitelist, will filter
    * if whitelisting is on, and category is not in whitelist, will not filter
    * 
    * If blacklist is specified and category is in blacklist, will not filter
    * 
    * If disable=true, will never filter on category page
    */
    function shouldShow( $categoryId )
    {
        $this->argumentWas = $categoryId;
        return $this->willReturn;
    }   
    
    function willReturn( $val )
    {
        $this->willReturn = $val;
    }
    
    function argumentWas()
    {
        return $this->argumentWas;
    }
    
    function isInWhiteList( $id ) {}
    function isInBlackList( $id ) {}
}