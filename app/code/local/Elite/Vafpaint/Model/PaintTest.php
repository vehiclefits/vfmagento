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
class Elite_Vafpaint_Model_PaintTest extends Elite_Vaf_TestCase
{
    const CODE = 'B-27MZ';
    const COLOR = '#9CBBCC';
    const NAME = 'Avignon Blue Metallic Clearcoat';
    
    function testCode()
    {
        $paint = new Elite_Vafpaint_Model_Paint( self::CODE, '', '' );
        $this->assertEquals( self::CODE, $paint->getCode() );
    }
    
    function testName()
    {
        $paint = new Elite_Vafpaint_Model_Paint( '', self::NAME, '' );
        $this->assertEquals( self::NAME, $paint->getName() );
    }
    
    function testColor()
    {
        $paint = new Elite_Vafpaint_Model_Paint( '', '', self::COLOR );
        $this->assertEquals( self::COLOR, $paint->getColor() );
    }
    
    function testRender1()
    {
		$paint = new Elite_Vafpaint_Model_Paint( self::CODE, self::NAME, '#9CBBCC' );
		$html = $paint->render();
		$html = explode( "\n", $html );
		$this->assertEquals( "<div style=\"background-color:#9CBBCC; width:90px; height:30px;\"></div>", $html[0] );
    }
    
    function testRender2()
    {
		$paint = new Elite_Vafpaint_Model_Paint( '123', 'Artic Ice Blue', self::COLOR );
		$html = $paint->render();
		$html = explode( "\n", $html );
		$this->assertEquals( "<br />Artic Ice Blue (123)", $html[1] );
    }
}