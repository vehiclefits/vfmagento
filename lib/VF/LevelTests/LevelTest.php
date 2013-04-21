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
class VF_LevelTests_LevelTest extends Elite_Vaf_TestCase
{
    
    function testConstructorSetsType()
    {
        $entity = new VF_Level('make');   
        $this->assertSame('make', $entity->getType() );
    }
    
    function testConstructorSetsId()
    {
        $id = $this->insertMake();
        $entity = $this->findMakeById( $id );
        $this->assertSame( $id, $entity->getId() );
    }
    
    function testInitGetsTitle()
    {
        $id = $this->insertMake( self::ENTITY_TITLE );
        $entity = $this->findMakeById( $id );
        $this->assertSame( self::ENTITY_TITLE, $entity->getTitle() );
    }
    
    /**
    * @expectedException  Exception
    */
    function testInitThrowsExceptionForUnfoundId()
    {
        $this->findMakeById( self::NON_EXISTANT_ID );
    }
    
    /**
    * @expectedException VF_Level_Exception_InvalidLevel
    */
    function testInitThrowsExceptionIfTypeInvalid()
    {
        $id = $this->insertMake();
        $entity = new VF_Level( self::INVALID_TYPE, $id );
    }
    
    function testInitDoesNothingIfNoId()
    {
        try
        {
            $entity = new VF_Level( self::INVALID_TYPE, 0 );
        }
        catch( Exception $e )
        {
            return $this->assertTrue( false, 'instantiating with invalid type will not throw exception as long as no id was passed' );
        }
        $this->assertTrue( true, 'instantiating with invalid type will not throw exception as long as no id was passed' );
    }
    
    function testGetTitle()
    {
        $id = $this->insertMake( self::ENTITY_TITLE );
        $entity = $this->findMakeById( $id );
        $this->assertSame( self::ENTITY_TITLE, $entity->getTitle() );
    }

    function testDeleteFits()
    {
        $vehicle = $this->createMMY();
        $this->insertMappingMMY( $vehicle, 1 );
        $level = new VF_Level( 'year', $vehicle->getLevel('year')->getId() );
        $level->deleteFits();
    }
    
    function testPrefixingZero()
    {
        $make = $this->newMake('039');
        $id = $make->save();
        
        $entity = $this->findMakeById( $id );
        $this->assertSame( '039', $entity->getTitle() );
    }
    
    function testPrefixingZero2()
    {
        $make = $this->newMake('039');
        $make->save();
        $make = $this->newMake('039');
        $id1 = $make->save();
        
        $make = $this->newMake('39');
        $id2 = $make->save();
        
        $this->assertNotSame( $id1, $id2 );
    }
    
    function testShouldTrimWhitespace()
    {
        $make = $this->newMake(' 039 ');
        $id = $make->save();
        
        $make = $this->levelFinder()->findEntityByTitle('make','039');
        $this->assertEquals( $id, $make->getId(), 'should trim whitespace');
    }
    
    function levelFinder()
    {
        return new VF_Level_Finder();
    }
    
         
}