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
class Elite_Vaftire_Model_FlexibleSearchTests_TypeTest extends Elite_TestCase
{
	function testShouldGetFromRequest()
    {
        $flexibleSearch = $this->flexibleTireSearch(array('tire_type'=>2,'section_width'=>'205', 'aspect_ratio'=>'55', 'diameter'=>'16'));
        $this->assertEquals( 2, $flexibleSearch->tireType(), 'should get tire type from request' );
    }
    
    function testShouldStoreInSession()
    {
        $flexibleSearch = $this->flexibleTireSearch(array('tire_type'=>2,'section_width'=>'205', 'aspect_ratio'=>'55', 'diameter'=>'16'));
        Elite_Vaf_Singleton::getInstance()->storeFitInSession();
        $this->assertEquals( 2, $this->flexibleTireSearch(array())->tireType(), 'should store tire type in session' );
    }
    
    function testShouldClearFromSession()
    {
        $flexibleSearch = $this->flexibleTireSearch(array('tire_type'=>2,'section_width'=>'205', 'aspect_ratio'=>'55', 'diameter'=>'16'));
        Elite_Vaf_Singleton::getInstance()->storeFitInSession();
        
        $flexibleSearch = $this->flexibleTireSearch(array('tire_type'=>'','section_width'=>'0', 'aspect_ratio'=>'0', 'diameter'=>'0'));
        Elite_Vaf_Singleton::getInstance()->storeFitInSession();
        
        $this->assertNull( $this->flexibleTireSearch()->tireType(), 'should clear tire type from session' );
    }
    
    function testShouldClearFromSession2()
    {
        $flexibleSearch = $this->flexibleTireSearch(array('tire_type'=>2,'section_width'=>'205', 'aspect_ratio'=>'55', 'diameter'=>'16'));
        Elite_Vaf_Singleton::getInstance()->storeFitInSession();
        
        $flexibleSearch = $this->flexibleTireSearch(array('tire_type'=>'','section_width'=>'0', 'aspect_ratio'=>'0', 'diameter'=>'0'));
        Elite_Vaf_Singleton::getInstance()->storeFitInSession();
        
        $this->assertNull( $flexibleSearch->tireType(), 'should clear tire type from session' );
    }
}