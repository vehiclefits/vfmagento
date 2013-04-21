<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

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