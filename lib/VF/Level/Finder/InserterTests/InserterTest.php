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
class VF_Level_Finder_InserterTests_InserterTest extends Elite_Vaf_TestCase
{
    const PARENT_ID = 1;
    
    function testSaveLevelWithParent()
    {
        $model = new VF_Level('model');
        $model->setTitle( self::ENTITY_TITLE );
        $model->save(self::PARENT_ID);
        $model = $this->findEntityById( $model->getId(), $model->getType(), self::PARENT_ID );
        $this->assertSame( self::ENTITY_TITLE, $model->getTitle(), 'saved entity should have correct title value' );
    }

    function testSaveSetsMakeId()
    {
        $make = new VF_Level('make');
        $make->setTitle( self::ENTITY_TITLE );
        $make->save();
        $this->assertNotEquals( 0, $make->getId(), 'saved entity should have an id value' );
    }
    
    function testSaveSetsMakeId2()
    {
        $make = new VF_Level('make');
        $make->setTitle( self::ENTITY_TITLE );
        $make->save(array());
        $this->assertNotEquals( 0, $make->getId(), 'saved entity should have an id value' );
    }

    function testSaveSetsModelId()
    {
        $model = new VF_Level('model');
        $model->setTitle( self::ENTITY_TITLE );
        $model->save(self::PARENT_ID);
        $model = $this->findEntityById( $model->getId(), $model->getType(), self::PARENT_ID );
        $this->assertNotEquals( 0, $model->getId(), 'saved entity should have an id value' );
    }

    function testSaveSetsModelId2()
    {
        $model = new VF_Level('model');
        $model->setTitle( self::ENTITY_TITLE );
        $model->save(array('make'=>self::PARENT_ID));
        $model = $this->findEntityById( $model->getId(), $model->getType(), self::PARENT_ID );
        $this->assertNotEquals( 0, $model->getId(), 'saved entity should have an id value' );
    }
    
    function testSaveIsRepeatable()
    {
        $vehicle = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2000));
        
        $model = new VF_Level('model');
        $model->setTitle('Civic');
        $model->save( $vehicle->getValue('make') );
        
        $this->assertEquals( $vehicle->getValue('model'), $model->getId(), 'saving multiple times should keep the same id' );
    }
    
    function testSaveRootLevel()
    {
        $make = new VF_Level('make');
        $make->setTitle( self::ENTITY_TITLE );
        $make = $this->saveAndReload( $make );
        $this->assertNotEquals( 0, $make->getId(), 'saved entity should have an id value' );
        $this->assertSame( self::ENTITY_TITLE, $make->getTitle(), 'saved entity should have correct title value' );
    }

}