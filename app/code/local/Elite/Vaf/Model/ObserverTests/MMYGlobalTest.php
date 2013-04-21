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
class Elite_Vaf_Model_ObserverTests_MMYGlobalTest extends Elite_Vaf_Model_ObserverTests_TestCase
{

    function doSetUp()
    {
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->dropExistingTables();
        $schemaGenerator->execute(array(
            'make' => array('global'=>true),
            'model',
            'year' => array('global'=>true)
        ));
        $this->startTransaction();
    }

    function doTearDown()
    {
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->dropExistingTables();
    }

    function testShouldAddFitment()
    {
        $product = $this->product();
        $vehicle1 = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2000));
        $vehicle2 = $this->createVehicle(array('make'=>'Ford', 'model'=>'F-150', 'year'=>2000));

        // request to add a vehicle based upon it's 'formatted string' (level name [year] and ID).
        $formattedString = 'make:'.$vehicle2->getValue('make').';model:' . $vehicle2->getValue('model') . ';year:'.$vehicle2->getValue('year').';';
        $request = $this->getRequest();
        $request->setParam('vaf', array($formattedString));

        $this->observer($request);

        $this->assertTrue($product->fitsVehicle($vehicle2), 'should have added the vehicle');
        $this->assertFalse($product->fitsVehicle($vehicle1), 'should NOT add the wrong vehicle');
    }
    
    
}