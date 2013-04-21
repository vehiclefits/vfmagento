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
class VF_SchemaTests_SchemaSpaceInLevelNameTest extends VF_Import_TestCase
{
    function doSetUp()
    {
	$this->switchSchema('make,model type,year',true);
    }
    
    function testLevels()
    {
        $schema = new VF_Schema();
        $this->assertEquals( array('make','model type','year'), $schema->getLevels(), 'should allow spaces in level name' );
    }

    function testImport()
    {
	$this->importVehiclesList('make,model type, year' . "\n" .
		'Honda, Civic EX, 2000' );
    }

    function testGetFits()
    {
        $product = $this->newProduct(1);
        $vehicle = $this->createVehicle(array('make'=>'Honda', 'model type'=>'Civic', 'year'=>2000));
        $product->addVafFit( $vehicle->toValueArray() );

        $actual = $product->getFits();
        $this->assertEquals( 1, count($actual) );
        $fit = $actual[0];
        $this->assertEquals( $vehicle->toValueArray(), array('make'=>$fit->make_id,'model type'=>$fit->model_type_id,'year'=>$fit->year_id), 'should get fitment' );
    }
}
