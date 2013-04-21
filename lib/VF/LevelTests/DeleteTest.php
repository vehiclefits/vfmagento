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
class VF_LevelTests_DeleteTest extends Elite_Vaf_TestCase
{
	function doSetUp()
	{
		$this->switchSchema('make,model,year');
	}
	
	function testShouldDeleteLevel()
	{
		$vehicle = $this->createMMY('Honda','Civic','2000');
		$vehicle->getLevel('model')->delete();
		$result = $this->query('select count(*) from elite_level_1_model where id = '.$vehicle->getValue('model'));
		$this->assertEquals( 0, $result->fetchColumn(), 'should be able to delete a level' );
	}
	
	function testShouldDeleteVehicle_WhenDeletingLevel()
	{
		$vehicle = $this->createMMY('Honda','Civic','2000');
		$vehicle->getLevel('model')->delete();
		$result = $this->query('select count(*) from elite_1_definition where id = '.$vehicle->getId());
		$this->assertEquals( 0, $result->fetchColumn(), 'should delete vehicle record when deleting a model' );
	}
    
    function testShouldDeleteVehicleWithSameModelId_WhenDeletingModel()
    {
        $vehicle = $this->createMMY('Honda','Civic','2000');
        $vehicle->getLevel('model')->delete();
        $result = $this->query('select count(*) from elite_1_definition where model_id = '.$vehicle->getValue('model'));
        $this->assertEquals( 0, $result->fetchColumn(), 'should delete vehicle record when deleting a model' );
    }
	
	function testShouldDeleteYear_WhenDeletingModel()
	{
		$vehicle = $this->createMMY('Honda','Civic','2000');
		$vehicle->getLevel('model')->delete();
		$result = $this->query('select count(*) from elite_level_1_year where id = '.$vehicle->getValue('year'));
		$this->assertEquals( 0, $result->fetchColumn(), 'should delete year record when deleting a model' );
	}
	
	function testShouldDeleteYear_WhenDeletingMake()
	{
		$vehicle = $this->createMMY('Honda','Civic','2000');
		$vehicle->getLevel('make')->delete();
		$result = $this->query('select count(*) from elite_level_1_year where id = '.$vehicle->getValue('year'));
		$this->assertEquals( 0, $result->fetchColumn(), 'should delete year record when deleting a model' );
	}
	
	function testShouldDeleteBoltPatterns_WhenDeletingYear()
	{
		$vehicle = $this->createMMY('Honda','Civic','2000');
		$vehicle = new Elite_Vafwheel_Model_Vehicle($vehicle);
		$vehicle->addBoltPattern(Elite_Vafwheel_Model_BoltPattern::create('4x114.3'));
		
		$vehicle->getLevel('year')->delete();
		                                                                                                                
		$result = $this->query('select count(*) from elite_definition_wheel where leaf_id = '.$vehicle->getValue('year'));
		$this->assertEquals( 0, $result->fetchColumn(), 'should delete wheel record when deleting a year' );
	}
	
	/** @todo all these tests, should be able to have a mapping object as a first class object. Need findEntityByTitle() method instead of passing the id */
	function testShouldDeleteFitmentNotes_WhenDeletingMake()
	{
		$vehicle = $this->createMMY('Honda','Civic','2000');
		$mapping_id = $this->insertMappingMMY($vehicle,1);
		
		$this->noteFinder()->insertNoteRelationship($mapping_id,'code1');
		
		$vehicle->getLevel('make')->delete();
		
		$result = $this->query('select count(*) from elite_mapping_notes');
		$this->assertEquals( 0, $result->fetchColumn(), 'should delete fitment notes when deleting a make' );
	}
	
}