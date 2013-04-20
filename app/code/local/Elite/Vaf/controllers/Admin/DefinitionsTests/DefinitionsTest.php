<?php
class Elite_Vaf_Adminhtml_Block_DefinitionsTests_DefinitionTest extends Elite_Vaf_TestCase
{
    
    function testConstruct()
    {
        $block = new Elite_Vaf_Adminhtml_Block_Definitions;
    }
    
    function testGetType()
    {
        return $this->markTestIncomplete();
        list($make, $model, $year) = $this->createMMY( 'a', 'b', 'c' );
        $block = new Elite_Vaf_Adminhtml_Block_Definitions_TestSubClass;
        $block->setRequest( $this->getRequest( array( 'entity' => 'year' ) ) );
        $block->setRequest( $this->getRequest( array( 'id' => $year ) ) );
        $this->assertEquals( 'year', $block->getType() );
    }
    
}