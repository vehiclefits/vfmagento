<?php
class Elite_Vaf_Adminhtml_Block_DefinitionsTests_ShouldSaveTest extends Elite_Vaf_TestCase
{
    const TITLE = 'test title';
    const ARBITRARY_STRING = 'sdfsdf';
       
    function testSaveActionNew()
    {
        $request = $this->getRequest( array(
            'id' => 0, // should really be called the parent_id or something
            'save' => self::ARBITRARY_STRING, // FOR some reason the way this was implemented in the view script, the save button passes the id for editing, but an arbitrary string when doing new
            'title' => self::TITLE
        ));
        $controller = $this->definitionsController($request);
        
        $controller->saveAction();
        $entity = $this->findEntityByTitle( 'make', self::TITLE );       
        $this->assertTrue( $this->entityCreatedWithTitle( $entity, self::TITLE ) );
    }
    
    function testSaveActionEdit()
    {
        $make_id = $this->insertMake( self::ARBITRARY_STRING );
        
        $request = $this->getRequest( array(
            'id' => 0, // should really be called the parent_id or something
            'save' => self::ARBITRARY_STRING,
            'title' => self::TITLE
        ));
        $controller = $this->definitionsController($request);
        
        $controller->saveAction();
        $entity = $this->findEntityByTitle( 'make', self::TITLE );
        $this->assertTrue( $this->entityCreatedWithTitle( $entity, self::TITLE ) );
    }
    
    protected function entityCreatedWithTitle( $entity, $title )
    {
        return (bool)( 0 != $entity->getId() ) && ( 'make' == $entity->getType() ) && ( $entity->getTitle() == $title );
    }
    
}