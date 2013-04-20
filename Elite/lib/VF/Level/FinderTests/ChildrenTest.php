<?php
class VF_Level_FinderTests_ChildrenTest extends Elite_Vaf_TestCase
{
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testFindChildren()
    {
        return $this->markTestIncomplete();
        //$vehicle1 = $this->createMMY('Make', 'Model1');
//        $vehicle2 = $this->createMMY('Make', 'Model2');
//        $make = new VF_Level('make',$vehicle1->getValue('make'));
//        $children = $make->getChildren();
//        $children = $make->getChildren();
    }
    
    function testGetChildCountReturns0ForLeafLevel()
    {
        $entity = new VF_Level('year');
        $this->assertSame( 0, $entity->getChildCount(), 'get child count should return 0 when no children have been inserted' );
    }
    
    /**
    * @expectedException Exception
    */
    function testGetChildrenThrowsExceptionForLeafLevel()
    {
        $year = new VF_Level( 'year' );
        $year->getChildren();
    }
    
    function testGetChildren()
    {
        $vehicle = $this->createMMY();        
        $make = $this->findMakeById( $vehicle->getLevel('make')->getId() );
        $children = $make->getChildren();
        $this->assertTrue( $vehicle->getLevel('model')->getId()  == $children[0]->getId(), 'gets back the right make' );
        $this->assertEquals( 1, count($children), 'gets back only the right make' );
    }
    
    function testGetChildrenModel()
    {
        $vehicle = $this->createMMY();
        $this->assertEquals( 1, count($vehicle->getLevel('make')->getChildren()), 'get child count should count the model we just inserted' );
    }
    
    function testGetChildCount()
    {
        $vehicle = $this->createMMY();
        $this->assertEquals( 1, $vehicle->getLevel('make')->getChildCount(), 'get child count should count the model we just inserted' );
    }
    
    function testShouldReturn0AfterDeletingChildren()
    {
        $vehicle = $this->createMMY();
        $vehicle->getLevel('year')->delete();
        $this->assertSame( 0, $vehicle->getLevel('model')->getChildCount(), 'should return 0 after deleting children' );
    }
    
}
