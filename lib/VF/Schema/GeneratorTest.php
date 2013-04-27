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
class VF_Schema_GeneratorTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->schemaGenerator()->dropExistingTables();
    }
    
    function tearDown()
    {
        $schemaGenerator = new VF_Schema_Generator();
        $schemaGenerator->dropExistingTables();
    }
    
    /**
    * @expectedException VF_Level_Exception
    */
    function testShouldThrowExceptionForLessThanTwoLevels()
    {
        $this->schemaGenerator()->execute(array('make'));
    }

    function testShouldDefaultToMasterSchema()
    {
        $this->schemaGenerator()->execute(array('make','model','year'));
        $schema = new VF_Schema;
        $this->assertEquals(1,$schema->id(), 'schema should default to master schema represented by ID=1');
    }

    function testMasterSchemaShouldCreateTablesWithID1()
    {
        $this->schemaGenerator()->execute(array('make','model','year'));
        $expectedTable = 'elite_level_1_make';
        $tables = $this->getReadAdapter()->listTables();
        $this->assertTrue(in_array($expectedTable, $tables), "master schema should create make with '1' in it's name");
    }
        
    function testMMY()
    {
        $this->schemaGenerator()->execute(array('make','model','year'));
        $this->assertEquals( array('make','model','year'), $this->schema()->getLevels(), 'should switch levels to MMY' );
    }
    
    function testYMM()
    {
        $this->schemaGenerator()->execute(array('year','make','model'));
        $this->assertEquals( array('year','make','model'), $this->schema()->getLevels(), 'should switch levels to YMM' );
    }
            
    function testYMM_MakeShouldHaveParent_WhenNotGlobal()
    {
        $this->schemaGenerator()->execute(array('year','make','model'));
        $this->assertTrue( $this->schema()->hasParent('make'), 'make should have parent when not global' );
    }

    function testShouldGenerateMultipleSchemas()
    {
        $this->schemaGenerator()->execute(array('make','model','year'));
        $schema = VF_Schema::create('foo,bar');

        $expectedTable = 'elite_level_'.$schema->id().'_foo';
        $tables = $this->getReadAdapter()->listTables();
        $this->assertTrue(in_array($expectedTable, $tables), 'should create table for new schema `elite_level_x_foo`');
    }
    
    function schema()
    {
        return new VF_Schema();
    }
}