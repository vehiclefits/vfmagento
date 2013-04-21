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
class Elite_Vaftire_Model_FlexibleSearchTests_SectionWidthTest extends Elite_Vaf_TestCase
{
    function testShouldGetFromRequest()
    {
        $flexibleSearch = $this->flexibleTireSearch(array('section_width'=>'205', 'aspect_ratio'=>'55', 'diameter'=>'16'));
        $this->assertEquals( 205, $flexibleSearch->sectionWidth(), 'should get section width from request' );
    }
    
    function testShouldStoreInSession()
    {
        $flexibleSearch = $this->flexibleTireSearch(array('section_width'=>'205', 'aspect_ratio'=>'55', 'diameter'=>'16'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        $this->assertEquals( 205, $this->flexibleTireSearch()->sectionWidth(), 'should store section width in session' );
    }
    
    function testShouldClearFromSession()
    {
        $flexibleSearch = $this->flexibleTireSearch(array('section_width'=>'205', 'aspect_ratio'=>'55', 'diameter'=>'16'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        $flexibleSearch = $this->flexibleTireSearch(array('section_width'=>'0', 'aspect_ratio'=>'0', 'diameter'=>'0'));
        Elite_Vaf_Helper_Data::getInstance()->storeFitInSession();
        
        $this->assertNull( $this->flexibleTireSearch()->sectionWidth(), 'should clear section width from session' );
    }
}