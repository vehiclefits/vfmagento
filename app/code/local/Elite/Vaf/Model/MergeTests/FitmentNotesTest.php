<?php

class Elite_Vaf_Model_MergeTests_FitmentNotesTest extends Elite_Vaf_TestCase
{

    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }

    function testShouldMergeYear()
    {
        return $this->markTestIncomplete();
//        $this->createNoteDefinition('code1', 'this is my message');
//        $this->createNoteDefinition('code2', 'this is my message2');
//
//        $vehicle1 = $this->createMMY('Honda', 'Civic', '2000');
//        $vehicle2 = $this->createMMY('Honda', 'Civic', '2001');
//
//        $product1 = $this->newNoteProduct(1);
//        $product1->addVafFit($vehicle1->toValueArray());
//        $product1->addNote($vehicle1, 'code1');
//
//        $product2 = $this->newNoteProduct(2);
//        $product2->addVafFit($vehicle2->toValueArray());
//        $product2->addNote($vehicle2, 'code2');
//
//        $slaveLevels = array(
//            array('year', $vehicle1),
//            array('year', $vehicle2),
//        );
//        $masterLevel = array('year', $vehicle2);
//
//        $this->merge($slaveLevels, $masterLevel);
//
//        $this->assertEquals(array('code1', 'code2'), $product1->notesCodes($vehicle2));
//        $this->assertEquals(array('code1', 'code2'), $product2->notesCodes($vehicle2));
    }

}