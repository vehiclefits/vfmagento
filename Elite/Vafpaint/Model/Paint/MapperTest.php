<?php
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
		$this->getReadAdapter()->insert( 'elite_Fitment_paint', array(
			'Fitment_id' => $this->definition->getLevel('year')->getId(),
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
		$paint = $this->mapper->findByFitId( $this->definition->getLevel('year')->getId() );
		$this->assertEquals( self::CODE, $paint[0]->getCode() );
	}
}