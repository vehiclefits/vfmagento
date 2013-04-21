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
class VF_LevelTests_LevelsTest extends Elite_Vaf_TestCase
{
    
    protected function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testGetType()
    {
        $entity = new VF_Level('make');
        $this->assertSame( self::ENTITY_TYPE_MAKE, $entity->getType() );
    }

    function testgetNextLevelMake()
    {
        $entity = new VF_Level('make');
        $this->assertEquals( self::ENTITY_TYPE_MODEL, $entity->getNextLevel(), 'getNextLevel should return "model" for a entity of type "make"' );
    }
    
    function testgetNextLevelModel()
    {
        $entity = new VF_Level('model');
        $this->assertEquals( self::ENTITY_TYPE_YEAR, $entity->getNextLevel(), 'getNextLevel should return "year" for a entity of type "model"' );
    }
    
    function testgetNextLevelYear()
    {
        $entity = new VF_Level('year');
        $this->assertEquals( '', $entity->getNextLevel(), 'getNextLevel should return emtpy string if called on a leaf level' );
    }
    
    function testgetPrevLevelMake()
    {
        $entity = new VF_Level('make');
        $this->assertEquals( '', $entity->getPrevLevel(), 'getPrevLevel should return emtpy string if called on a root level' );
    }
    
    function testgetPrevLevelModel()
    {
        $entity = new VF_Level('model');
        $this->assertEquals( self::ENTITY_TYPE_MAKE, $entity->getPrevLevel(), 'getPrevLevel should return "make" for a entity of type "model"' );
    }
    
    function testgetPrevLevelYear()
    {
        $entity = new VF_Level('year');
        $this->assertEquals( self::ENTITY_TYPE_MODEL, $entity->getPrevLevel(), 'getPrevLevel should return "model" for a entity of type "year"' );
    }
    
          
}
