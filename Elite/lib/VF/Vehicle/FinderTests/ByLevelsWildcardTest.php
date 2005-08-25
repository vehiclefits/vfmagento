<?php
class VF_Vehicle_FinderTests_ByLevelsWildcardTest extends VF_Vehicle_FinderTests_TestCase
{
	function testWildcard()
    {
        $this->createMMY( 'Honda', 'F-150', '2000' );
        $vehicles = $this->getFinder()->findByLevels( array('make'=>'Honda','model'=>'F-*','year'=>2000));
        $this->assertEquals(1,count($vehicles));
    }
    
}