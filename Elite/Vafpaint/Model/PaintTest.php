<?php
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