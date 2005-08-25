<?php
class VF_Level_FinderTests_ChildrenGlobalTest extends Elite_Vaf_TestCase
{
    
    function doSetUp()
    {
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->dropExistingTables();
        $schemaGenerator->execute(array(
            'year',
            'make' => array('global'=>true),
            'model'
        ));
        $this->startTransaction();
    }
    
    function doTearDown()
    {
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->dropExistingTables();
    }
    
    function testShouldSearchUnderSameParentId()
    {
        $y2000 = $this->newYear('2000');
        $y2000->save();
        
        $y2001 = $this->newYear('2001');
        $y2001->save();
        
        $honda = $this->newMake('Honda');
        $honda->save($y2000->getId());
        
        $children = $y2000->getChildren();
        $this->assertEquals( 1, count($children), 'should search under same parent id' );
    }
    
    function testShouldNotSearchUnderDifferentParentId()
    {
        $y2000 = $this->newYear('2000');
        $y2000->save();
        
        $y2001 = $this->newYear('2001');
        $y2001->save();
        
        $honda = $this->newMake('Honda');
        $honda->save($y2000->getId());
        
        $children = $y2001->getChildren();
        $this->assertEquals( 0, count($children), 'should not search under different parent ids' );
    }
    
    function testShouldSearchUnderMultipleParentId()
    {
        $y2000 = $this->newYear('2000');
        $y2000->save();
        
        $y2001 = $this->newYear('2001');
        $y2001->save();
        
        $honda = $this->newMake('Honda');
        $honda->save($y2000->getId());
        
        $honda = $this->newMake('Honda');
        $honda->save($y2001->getId());
        
        $children = $y2000->getChildren();
        $this->assertEquals( 1, count($children), 'should search under multiple parent id' );
        
        $children = $y2001->getChildren();
        $this->assertEquals( 1, count($children), 'should search under multiple parent id' );
    }
    
    function testShouldSearchUnderMultipleParentId2()
    {
        $y2000 = $this->newYear('2000');
        $y2000->save();
        
        $y2001 = $this->newYear('2001');
        $y2001->save();
        
        $honda = $this->newMake('Honda');
        $honda->save($y2000->getId());
        
        $honda = $this->newMake('Honda');
        $honda->save($y2001->getId());
        
        $children = $y2000->getChildCount();
        $this->assertEquals( 1, $children, 'should search under multiple parent id' );
        
        $children = $y2001->getChildCount();
        $this->assertEquals( 1, $children, 'should search under multiple parent id' );
    }
    
    /**
    * @expectedException Exception
    */
    function testShouldThrowExceptionOnAmbiguousRequest()
    {
        $y2000 = $this->newYear('2000');
        $y2000->save();
        
        $honda = $this->newMake('Honda');
        $honda->save($y2000->getId());
        
        $children = $honda->getChildCount();
    }
    
    /**
    * @expectedException Exception
    */
    function testShouldThrowExceptionOnAmbiguousRequest2()
    {
        $y2000 = $this->newYear('2000');
        $y2000->save();
        
        $honda = $this->newMake('Honda');
        $honda->save($y2000->getId());
        
        $children = $honda->getChildren();
    }
    
}
