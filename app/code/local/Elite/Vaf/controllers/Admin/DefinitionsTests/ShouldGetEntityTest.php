<?php
class Elite_Vaf_Adminhtml_Block_DefinitionsTests_ShouldGetEntityTest extends Elite_Vaf_TestCase
{

    function testGetEntityDefaultsToRootLevel()
    {
        $controller = $this->definitionsController( $this->getRequest( array( 'entity' => '' ) ) ); 
        $this->assertEquals( 'make', $controller->getEntity()->getType(), 'getEntity should return the correct type even if user requested blank string' );
    }
    
    function testGetEntityModel()
    {
        $controller = $this->definitionsController( $this->getRequest( array( 'entity' => 'model' ) ) ); 
        $this->assertEquals( 'model', $controller->getEntity()->getType(), 'getEntity should return the correct type' );
    }
    
    function testGetEntityYear()
    {
        $controller = $this->definitionsController( $this->getRequest( array( 'entity' => 'year' ) ) ); 
        $this->assertEquals( 'year', $controller->getEntity()->getType(), 'getEntity should return the correct type' );
    }

}