<?php
class Elite_Vaf_Adminhtml_Block_DefinitionsTests_ShouldGetDefaultLevelFOOTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
		$this->switchSchema('foo,bar');
    }
    
    function testDefaultLevel2()
    {
    	$this->assertEquals( 'foo', $this->definitionsController()->getDefaultLevel() );
    }
    
}