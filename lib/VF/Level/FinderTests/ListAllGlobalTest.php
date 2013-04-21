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
class VF_Level_FinderTests_ListAllGlobalTest extends Elite_Vaf_TestCase
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
    
    function testListAllObeysParentIdForMake()
    {
        $y2000 = $this->newYear('2000');
        $y2000->save();
        
        $honda = $this->newMake('Honda');
        $honda->save($y2000);
        
        $y2001 = $this->newYear('2001');
        $y2001->save();
        
        $make = new VF_Level('make');
        $this->assertEquals( 0, count($make->listAll($y2001->getId())), 'list all should not find items from different parent id even in global mode' ); 
    }
    
    function testListAllObeysParentIdForModel()
    {
        $y2000 = $this->newYear('2000');
        $y2000->save();
        
        $y2001 = $this->newYear('2001');
        $y2001->save();
        
        $honda = $this->newMake('Honda');
        $honda->save($y2000);
        
        $honda = $this->newMake('Honda');
        $honda->save($y2001);
        
        $civic = $this->newModel('Civic');
        $civic->save($honda->getId());
        
        
        $model = new VF_Level('model');
        $models = $model->listAll(array('year'=>$y2000->getId(), 'make'=>$honda->getId()));
        $this->assertEquals( 0, count($models), 'list all should not find items from different parent id even in global mode' ); 
    }
    
}