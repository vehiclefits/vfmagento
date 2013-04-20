<?php
class Elite_Vaf_Adminhtml_Block_DefinitionsTests_ShouldGetDefaultLevelMMYTest extends Elite_Vaf_TestCase
{
    function testDefaultLevel()
    {
        $this->assertEquals( 'make', $this->definitionsController()->getDefaultLevel(), 'default level just means the root level?' );
    }
    
}