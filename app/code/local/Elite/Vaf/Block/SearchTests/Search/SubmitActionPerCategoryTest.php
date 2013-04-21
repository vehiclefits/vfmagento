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
class Elite_Vaf_Block_SearchTests_Search_SubmitActionPerCategoryTest extends Elite_Vaf_TestCase
{
    const HomePageSearch = 'vaf/product/list';

    function testRefresh()
    {
        $config = array(
            'search' => array('categoriesThatRefresh'=>'1,2,3', 'categoriesThatSubmitToHomepage'=>'4,5,6'),
            'category' => array()
        );
        $request = $this->request( 'category' );
        $block = $this->block( $config, $request );
        $this->assertEquals( '?', $block->categoryAction(1) );
    }

    function testHomepage()
    {
        $config = array(
            'search' => array('categoriesThatRefresh'=>'1,2,3', 'categoriesThatSubmitToHomepage'=>'4,5,6'),
            'category' => array()
        );
        $request = $this->request( 'category' );
        $block = $this->block( $config, $request );
        $this->assertEquals( 'vaf/product/list', $block->categoryAction(4) );
    }

    function testHomepage2()
    {
        $config = array(
            'search' => array('categoriesThatRefresh'=>'1,2,3', 'categoriesThatSubmitToHomepage'=>'4,5,6'),
            'category' => array()
        );
        $request = $this->request( 'category' );
        $block = $this->block( $config, $request );
        $block->setCurrentCategoryId(4);
        $this->assertEquals( 'vaf/product/list', $block->action() );
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

class Elite_Vaf_Block_Search_SubmitTestSub2 extends Elite_Vaf_Block_Search
{
    function url( $route )
    {
        return $route;
    }
}