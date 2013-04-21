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
class Elite_Vaf_Block_SearchTests_Search_SubmitActionTest extends Elite_Vaf_TestCase
{
    const HomePageSearch = 'vaf/product/list';
    
    function testShouldDefaultToHomepage()
    {
        $config = array(
            'search' => array(),
            'category' => array()
        );
        $request = $this->request( 'product' );
        $block = $this->block( $config, $request );
        $this->assertEquals( self::HomePageSearch, $block->action(), 'should default to homepage search' );   
    }
    
    function testWhenOnProductPageProductActionHomepage()
    {
        $config = array(
            'search' => array(
                'submitOnProductAction' => 'homepagesearch'
            ),
            'category' => array()
        );
        $request = $this->request( 'product' );
        $block = $this->block( $config, $request );
        $this->assertEquals( self::HomePageSearch, $block->action(), 'when on product page with submitOnProductAction set to "homepagesearch", should submit to homepage search' );   
    }
    
    function testWhenOnCMSPageActionHomepage()
    {
        $config = array(
            'search' => array(
                'submitAction' => 'homepagesearch'
            ),
            'category' => array()
        );
        $request = $this->request( 'page', 'cms' );
        $block = $this->block( $config, $request );
        $this->assertEquals( self::HomePageSearch, $block->action(), 'when on CMS page with submitAction set to "homepagesearch", should submit to homepage search' );   
    }
    
    function testWhenOnHomePageActionHomepage()
    {
        $config = array(
            'search' => array(
                'submitAction' => 'homepagesearch'
            ),
            'category' => array()
        );
        $request = $this->request( 'index', 'cms' );
        $block = $this->block( $config, $request );
        $this->assertEquals( self::HomePageSearch, $block->action(), 'when on home page with submitAction set to "homepagesearch", should submit to homepage search' );   
    }
    
    function testWhenOnHomePageHomepageActionHomepage()
    {
        $config = array(
            'search' => array(
                'submitOnHomepageAction' => 'homepagesearch'
            ),
            'category' => array()
        );
        $request = $this->request( 'index', 'cms' );
        $block = $this->block( $config, $request );
        $this->assertEquals( self::HomePageSearch, $block->action(), 'when on home page with submitOnHomepageAction set to "homepagesearch", should submit to homepage search' );   
    }
    
    function testWhenOnProductPageProductActionRefresh()
    {
        $config = array(
            'search' => array(
                'submitOnProductAction' => 'refresh'
            ),
            'category' => array()
        );
        $request = $this->request( 'product' );
        $block = $this->block( $config, $request );
        $this->assertEquals( '?', $block->action(), 'when on product page with submitOnProductAction equal to "refresh", action should be to refresh' );   
    }
    
    function testWhenOnCMSPageActionRefresh()
    {
        $config = array(
            'search' => array(
                'submitAction' => 'refresh'
            ),
            'category' => array()
        );
        $request = $this->request( 'page', 'cms' );
        $block = $this->block( $config, $request );
        $this->assertEquals( '?', $block->action(), 'when on CMS page with submitAction equal to "refresh", action should be to refresh' );   
    }
    
    function testWhenOnHomePageActionRefresh()
    {
        $config = array(
            'search' => array(
                'submitAction' => 'refresh'
            ),
            'category' => array()
        );
        $request = $this->request( 'index', 'cms' );
        $block = $this->block( $config, $request );
        $this->assertEquals( '?', $block->action(), 'when on home page with submitAction equal to "refresh", action should be to refresh' );   
    }
    
    function testWhenOnHomePageHomepageActionRefresh()
    {
        $config = array(
            'search' => array(
                'submitOnHomepageAction' => 'refresh'
            ),
            'category' => array()
        );
        $request = $this->request( 'index', 'cms' );
        $block = $this->block( $config, $request );
        $this->assertEquals( '?', $block->action(), 'when on home page with submitOnHomepageAction equal to "refresh", action should be to refresh' );   
    }
    
    function testWhenOnProductPageActionUrl()
    {
        $config = array(
            'search' => array(
                'submitAction' => 'http://google.com'
            ),
            'category' => array()
        );
        $request = $this->request( 'product' );
        $block = $this->block( $config, $request );
        $this->assertEquals( 'http://google.com', $block->action(), 'when on product page with submitAction equal to a URL, action should submit to that URL' );   
    }
    
    function testWhenOnProductPageProductActionUrl()
    {
        $config = array(
            'search' => array(
                'submitOnProductAction' => 'http://google.com'
            ),
            'category' => array()
        );
        $request = $this->request( 'product' );
        $block = $this->block( $config, $request );
        $this->assertEquals( 'http://google.com', $block->action(), 'when on product page with submitOnProductAction equal to a URL, action should submit to that URL' );   
    }    
    
    function testWhenOnCMSPageActionUrl()
    {
        $config = array(
            'search' => array(
                'submitAction' => 'http://google.com'
            ),
            'category' => array()
        );
        $request = $this->request( 'page', 'cms' );
        $block = $this->block( $config, $request );
        $this->assertEquals( 'http://google.com', $block->action(), 'when on CMS page with submitAction equal to a URL, action should be to that URL' );   
    }
    
    function testWhenOnHomePageActionUrl()
    {
        $config = array(
            'search' => array(
                'submitAction' => 'http://google.com'
            ),
            'category' => array()
        );
        $request = $this->request( 'index', 'cms' );
        $block = $this->block( $config, $request );
        $this->assertEquals( 'http://google.com', $block->action(), 'when on home page with submitAction equal to a URL, action should be to that URL' );   
    }
    
    function testWhenOnHomePageHomepageActionUrl()
    {
        $config = array(
            'search' => array(
                'submitOnHomepageAction' => 'http://google.com'
            ),
            'category' => array()
        );
        $request = $this->request( 'index', 'cms' );
        $block = $this->block( $config, $request );
        $this->assertEquals( 'http://google.com', $block->action(), 'when on home page with submitOnHomepageAction equal to a URL, action should be to that URL' );   
    }
    
    function testWhenOnProductPageShouldGiveProductPageActionPresedence()
    {
        $config = array(
            'search' => array(
                'submitAction' => 'foo',
                'submitOnProductAction' => 'bar'
            ),
            'category' => array()
        );
        $request = $this->request( 'product' );
        $block = $this->block( $config, $request );
        $this->assertEquals( 'bar', $block->action(), 'value of submitOnProductAction takes presedence over submitAction on product page' );   
    }
    
    function testWhenOnProductPageAndNoProductActionShouldDelegateToAction()
    {
        $config = array(
            'search' => array(
                'submitAction' => 'foo',
                'submitOnProductAction' => ''
            ),
            'category' => array()
        );
        $request = $this->request( 'product' );
        $block = $this->block( $config, $request );
        $this->assertEquals( 'foo', $block->action(), 'when on product page, and no specific product action is specified by a global action is, should delegate to the global action' );   
    }
    
    function testWhenOnCMSPageShouldGiveActionPresedence()
    {
        $config = array(
            'search' => array(
                'submitAction' => 'foo',
                'submitOnProductAction' => 'baz',
                'submitOnHomepageAction' => 'bat'
            ),
            'category' => array()
        );
        $request = $this->request( 'page', 'cms' );
        $block = $this->block( $config, $request );
        $this->assertEquals( 'foo', $block->action(), 'when on CMS page, value of submitAction should take presedence' );   
    }
    
    function testWhenOnOtherPageShouldGiveActionPresedence2()
    {
        $config = array(
            'search' => array(
                'submitAction' => 'foo',
                'submitOnProductAction' => ''
            ),
            'category' => array()
        );
        $request = $this->request( 'other' );
        $block = $this->block( $config, $request );
        $this->assertEquals( 'foo', $block->action(), 'when on CMS page, value of submitAction takes presedence over submitOnProductAction' );   
    }

    function testWhenOnCategoryPageActionRefresh()
    {
        $config = array(
            'search' => array(),
            'category' => array()
        );
        $request = $this->request( 'category' );
        $block = $this->block( $config, $request );
        $this->assertEquals( '?', $block->action(), 'when on category page defaults to refresh' );   
    }
    
    function testWhenOnCategoryPageActionUrl()
    {
        $config = array(
            'search' => array('submitOnCategoryAction' => 'bar'),
            'category' => array()
        );
        $request = $this->request( 'category' );
        $block = $this->block( $config, $request );
        $this->assertEquals( 'bar', $block->action(), 'when on category page and category action is set' );
    }
    
    function testWhenOnCategoryPageShouldIgnoreSubmitAction()
    {
        $config = array(
            'search' => array('submitAction' => 'bar'),
            'category' => array()
        );
        $request = $this->request( 'category' );
        $block = $this->block( $config, $request );
        $this->assertEquals( '?', $block->action(), 'when on category page and category action is set' );
    }

    protected function block( $config = array(), $request )
    {
        $block = new Elite_Vaf_Block_Search_SubmitTestSub;
        $block->setConfig( $this->config( $config ) );
        $block->setRequest( $request );
        return $block;
    }
    
    protected function config( $array )
    {
        return new Zend_Config( $array );
    }
}

class Elite_Vaf_Block_Search_SubmitTestSub extends Elite_Vaf_Block_Search
{
    function url( $route )
    {
        return $route;
    }
}