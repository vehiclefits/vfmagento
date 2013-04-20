<?php
class VF_Vehicle_FinderTests_PartialTest extends VF_Vehicle_FinderTests_TestCase
{
    function testShouldFindByAllLevels()
    {
        $level = $this->newMake('Ford/Honda');
        $level->save();
        
        $vehicle = $this->getFinder()->findOneByLevelIds( array('make'=>$level->getId()), VF_Vehicle_Finder::EXACT_ONLY );
        $this->assertEquals($level->getId(), $vehicle->getValue('make'), 'should find newly created level');
    }
}