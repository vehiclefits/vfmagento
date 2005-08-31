<?php
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
    protected function url( $route )
    {
        return $route;
    }
}