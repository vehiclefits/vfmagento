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
class Elite_Vaf_Block_SearchTests_CategoryChooser_IgnoreCategoryTest extends Elite_Vaf_Block_SearchTests_TestCase
{
    
    function testWhenCategoriesBlacklistedItFilters()
    {
        $search = $this->getBlockWithChooserConfig( array(
            'ignore' => 1
        ));
        $categories = $search->getFilteredCategories( array(
            array( 'id' => 1, 'url' => 'foo', 'title' => 'bar' ),
            array( 'id' => 2, 'url' => 'foo', 'title' => 'bar' )
        ));
        $count = count( $categories );
        $this->assertTrue( 1 == $count && $categories[0]['id'] == 2, 'filters out the category id 1 when user set the ignore paramater to 1' );
    }
    
    function testWhenMultipleCategoriesBlacklistedItFilters()
    {
        $search = $this->getBlockWithChooserConfig( array(
            'ignore' => '1, 2'
        ));
        $categories = $search->getFilteredCategories( array(
            array( 'id' => 1, 'url' => 'foo', 'title' => 'bar' ),
            array( 'id' => 2, 'url' => 'foo', 'title' => 'bar' )
        ));
        $this->assertTrue( 0 == count( $categories ), 'filters out the category id 1 & 2 when user set the ignore paramater to 1, 2' );
    }
    
    function testWhenNoConfigurationItDoesntFilter()
    {
        $search = $this->getBlockWithChooserConfig( array() );
        $categories = $search->getFilteredCategories( array(
            array( 'id' => 1, 'url' => 'foo', 'title' => 'bar' ),
            array( 'id' => 2, 'url' => 'foo', 'title' => 'bar' )
        ));
        $count = count( $categories );
        $this->assertTrue( 2 == $count && $categories[0]['id'] == 1 && $categories[1]['id'] == 2, 'does not filter category when user did not set ignore paramater' );
    }
    
}