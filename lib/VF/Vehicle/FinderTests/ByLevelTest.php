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
class VF_Vehicle_FinderTests_ByLevelTest extends VF_Vehicle_FinderTests_TestCase
{
    const MAKE = 'Honda';
    const MODEL = 'Civic';
    const YEAR = '2002';

    protected function doSetUp()
    {
        $this->schemaGenerator()->dropExistingTables();
        $this->switchSchema('make,model,year');
    }
    
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

    /**
     * @expectedException Exception
     */
    function testFindByYear2()
    {
        $vehicle1 = $this->createMMY( 'honda', 'civic', '2000' );
        $vehicle2 = $this->createMMY( 'honda', 'civic2', '2000' );

        $this->getFinder()->findByLevel( 'year', $vehicle1->getLevel('year')->getId() );
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