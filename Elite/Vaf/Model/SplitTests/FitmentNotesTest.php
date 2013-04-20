<?php

class Elite_Vaf_Model_SplitTests_FitmentNotesTest extends Elite_Vaf_TestCase
{

    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }

    function testShouldSplitNotesMapping()
    {
        return $this->markTestIncomplete();/*
        $this->createNoteDefinition('code1', 'this is my message');
        $vehicle = $this->createMMY('Honda', 'Civic', '2000');

        $product = $this->newNoteProduct(1);
        $product->addNote($vehicle, 'code1');

        $this->split($vehicle, 'year', array('2000', '2001'));


        $vehicle1 = $this->vehicleFinder()->findOneByLevels(array('make' => 'Honda', 'model' => 'Civic', 'year' => '2000'));
        $this->assertEquals(array('code1'), $product->notesCodes($vehicle1), 'SPLIT Should copy notes to each resultant vehicle/mapping');

        $vehicle2 = $this->vehicleFinder()->findOneByLevels(array('make' => 'Honda', 'model' => 'Civic', 'year' => '2001'));
        $this->assertEquals(array('code1'), $product->notesCodes($vehicle2), 'SPLIT Should copy notes to each resultant vehicle/mapping');*/
    }

}