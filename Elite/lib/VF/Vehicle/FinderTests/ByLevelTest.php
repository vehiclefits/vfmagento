<?php
class VF_Vehicle_FinderTests_ByLevelTest extends VF_Vehicle_FinderTests_TestCase
{
    const MAKE = 'Honda';
    const MODEL = 'Civic';
    const YEAR = '2002';
    
    function testFindAll()
    {
        $vehicle = $this->createMMY( self::MAKE, self::MODEL, self::YEAR );
        $vehicles = $this->getFinder()->findAll();
        $this->assertSame( self::MAKE, $vehicles[0]->getLevel('make')->getTitle() );
    }
        
    function testFindByMake()
    {
        $vehicle = $this->createMMY( self::MAKE, self::MODEL, self::YEAR );
        $vehicle = $this->getFinder()->findByLevel( 'make', $vehicle->getLevel('make')->getId() );
        $this->assertSame( self::MAKE, $vehicle->getLevel('make')->getTitle() );
        $this->assertSame( '', $vehicle->getLevel('model')->getTitle() );
        $this->assertSame( '', $vehicle->getLevel('year')->getTitle() );
    }
    
    function testFindByModel()
    {
        $vehicle = $this->createMMY( self::MAKE, self::MODEL, self::YEAR );
        $vehicle = $this->getFinder()->findByLevel( 'model', $vehicle->getLevel('model')->getId() );
        $this->assertSame( self::MAKE, $vehicle->getLevel('make')->getTitle() );
        $this->assertSame( self::MODEL, $vehicle->getLevel('model')->getTitle() );
        $this->assertSame( '', $vehicle->getLevel('year')->getTitle() );
    }
    
    function testFindByYear()
    {
        $vehicle = $this->createMMY( self::MAKE, self::MODEL, self::YEAR );
        $vehicle = $this->getFinder()->findByLevel( 'year', $vehicle->getLevel('year')->getId() );
        $this->assertSame( self::MAKE, $vehicle->getLevel('make')->getTitle() );
        $this->assertSame( self::MODEL, $vehicle->getLevel('model')->getTitle() );
        $this->assertSame( self::YEAR, $vehicle->getLevel('year')->getTitle() );
    }
        
    function testFindByYear2()
    {
        $vehicle1 = $this->createMMY( 'honda', 'civic', '2000' );
        $vehicle2 = $this->createMMY( 'honda', 'civic2', '2000' );
        
        $vehicle1 = $this->getFinder()->findByLevel( 'year', $vehicle1->getLevel('year')->getId() );
        $vehicle2 = $this->getFinder()->findByLevel( 'year', $vehicle2->getLevel('year')->getId() );
        
        $this->assertSame( 'civic', $vehicle1->getLevel('model')->getTitle() );
        $this->assertSame( 'civic2', $vehicle2->getLevel('model')->getTitle() );
    }
    
    function testFindById()
    {
        $vehicle = $this->createMMY( self::MAKE, self::MODEL, self::YEAR );
        $vehicle2 = $this->getFinder()->findById($vehicle->getId());
        $this->assertSame( (int)$vehicle->getId(), (int)$vehicle2->getId() );
    }
    
    /**
    * @expectedException Elite_Vaf_Exception_DefinitionNotFound
    */
    function testFindByLevelNotFoundLeaf()
    {
        $vehicle = $this->getFinder()->findByLeaf( 5 );
    }
    
    /**
    * @expectedException Elite_Vaf_Exception_DefinitionNotFound
    */
    function testFindByLevelNotFound()
    {
        $vehicle = $this->getFinder()->findByLevel( 'make', 5 );
    }
    
}