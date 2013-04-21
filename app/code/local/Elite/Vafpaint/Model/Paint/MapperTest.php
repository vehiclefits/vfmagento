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
class Elite_Vafpaint_Model_Paint_MapperTest extends Elite_Vaf_TestCase
{
	const CODE = 'code';
	const NAME = 'name';
	const COLOR = 'color';
	
	protected $id;
	
	function doSetUp()
	{
        $this->switchSchema('make,model,year');
        
		$this->definition = $this->createMMY();
		$this->getReadAdapter()->insert( 'elite_mapping_paint', array(
			'mapping_id' => $this->definition->getLevel('year')->getId(),
			'code' => self::CODE,
			'name' => self::NAME,
			'color' => self::COLOR
		));
		$this->id = $this->getReadAdapter()->lastInsertId();
		$this->mapper = new Elite_Vafpaint_Model_Paint_Mapper();
	}
	
	function testCode()
	{
		$paint = $this->mapper->find( $this->id );
		$this->assertEquals( self::CODE, $paint->getCode() );
	}
	
	function testName()
	{
		$paint = $this->mapper->find( $this->id );
		$this->assertEquals( self::NAME, $paint->getName() );
	}
	
	function testColor()
	{
		$paint = $this->mapper->find( $this->id );
		$this->assertEquals( self::COLOR, $paint->getColor() );
	}
	
	function testFindByFitId()
	{
		$paint = $this->mapper->findByVehicleId( $this->definition->getId() );
		$this->assertEquals( self::CODE, $paint[0]->getCode() );
	}
}