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
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Elite_Vaf_Model_SplitTests_FitmentNotesTest extends Elite_TestCase
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