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
class VF_LevelTests_DeleteGlobalTest extends Elite_Vaf_TestCase
{
	function doSetUp()
    {
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->dropExistingTables();
        $schemaGenerator->execute(array(
            'year',
            'make' => array('global'=>true),
            'model'
        ));
        $this->startTransaction();
    }
    
    function doTearDown()
    {
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->dropExistingTables();
    }
    
    function testShouldUnlinkYear()
    {
        $acura = $this->createVehicle(array('year'=>2000, 'make'=>'Acura', 'model'=>'Integra' ));
        $acura->unlink();
        $this->assertFalse( $this->vehicleExists(array('year'=>2000, 'make'=>'Acura', 'model'=>'Integra')), 'should unlink year' );
    }
    
    function testShouldNotUnlinkYearFromOtherMake()
    {
        $honda = $this->createVehicle(array('year'=>2000, 'make'=>'Honda', 'model'=>'Civic'));
        $acura = $this->createVehicle(array('year'=>2000, 'make'=>'Acura', 'model'=>'Integra'));
        
        $acura->unlink();
        $this->assertTrue( $this->vehicleExists(array('year'=>2000, 'make'=>'Honda', 'model'=>'Civic')), 'should not unlink 2000/honda when unlinking 2000/acura' );
    }
       
    /**
    * @expectedException VF_Level_Exception_NotFound
    */
    function testWhenDeleteMakeShouldDeleteMake()
    {
        $originalHonda = $this->createYMM('2000','Honda','Civic');
        $year = $originalHonda->getLevel('year');
        $make = $originalHonda->getLevel('make');
        $model = $originalHonda->getLevel('model');
        
        $vehicles = $this->vehicleFinder()->findByLevelIds( array('year'=>$year->getId(), 'make'=>$make->getId(), 'model'=>0), true );
        $vehicles[0]->unlink();
        
        // should have deleted make
        $make = $this->levelFinder()->find('make', $make->getId());
    }
    
    function testWhenDeleteModelShouldRetainMake()
    {
        $originalHonda = $this->createMMY('Honda','Civic','2000');
        $year = $originalHonda->getLevel('year');
        $make = $originalHonda->getLevel('make');
        $model = $originalHonda->getLevel('model');
        
        $vehicles = $this->vehicleFinder()->findByLevelIds( array('year'=>$year->getId(), 'make'=>$make->getId(), 'model'=>$model->getId()), true );
        $vehicles[0]->unlink();
        
        $make2 = $this->levelFinder()->find('make', $make->getId());
        $this->assertEquals($make->getId(), $make2->getId(), 'when deleting model, should retain make');
    }
    
    /**
    * @expectedException VF_Level_Exception_NotFound
    */
    function testWhenDeleteYearShouldNotHaveChildren()
    {
        $honda = $this->createVehicle(array( 'year'=>2000, 'make'=>'Honda', 'model'=>'Civic'));
        $honda->unlink();
        
        $this->levelFinder()->find('model',$honda->getValue('model'));
    }
    
    function testShouldDeleteModel()
    {
        $honda = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2000));
        $honda->unlink();
        $r = $this->getReadAdapter()->query("select count(*) from elite_level_1_model where title = 'Civic';");
        $this->assertEquals(0, $r->fetchColumn(), 'when unlinking a model, should delete that model' );
    }
    
    function testWhenUnlinkShouldNotDeleteYear()
    {
        $honda = $this->createVehicle(array('make'=>'Honda', 'model'=>'Civic', 'year'=>2000));
        $honda->unlink();
        $r = $this->getReadAdapter()->query("select count(*) from elite_level_1_year where title = '2000';");
        $this->assertEquals(1, $r->fetchColumn(), 'should not delete year' );
    }
    
    function testShouldDeleteMake_ShouldRetainModelsUnderDifferentYear()
    {
        $honda1 = $this->createVehicle(array('year'=>2000, 'make'=>'Honda', 'model'=>'Civic'));
        $honda2 = $this->createVehicle(array('year'=>2001, 'make'=>'Honda', 'model'=>'Accord'));
        
        $year = $honda1->getLevel('year');
        $make = $honda1->getLevel('make');
        $model = $honda1->getLevel('model');
        
        $vehicles = $this->vehicleFinder()->findByLevelIds( array('year'=>$year->getId(), 'make'=>$make->getId(), 'model'=>0), true );
        $vehicles[0]->unlink();
        
        $this->assertTrue($this->vehicleExists(array('year'=>2001, 'make'=>'Honda', 'model'=>'Accord')));
    }
	
}