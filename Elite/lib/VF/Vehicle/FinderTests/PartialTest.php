<?php
class Elite_Vaf_Model_Vehicle_FinderTests_PartialTest extends Elite_Vaf_Model_Vehicle_FinderTests_TestCase
{
    function testShouldFindByAllLevels()
    {
        $level = $this->newMake('Ford/Honda');
        $level->save();
        
        $vehicle = $this->getFinder()->findOneByLevelIds( array('make'=>$level->getId()), Elite_Vaf_Model_Vehicle_Finder::EXACT_ONLY );
        $this->assertEquals($level->getId(), $vehicle->getValue('make'), 'should find newly created level');
    }
}