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
class VF_SchemaTests_MultipleTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,option,year');
    }
    
    function testCreateNewSchemaId()
    {
        $schema = VF_Schema::create('foo,bar');
        $this->assertTrue( $schema->id() > 0 );
    }
    
    function testGetsDefaultSchemaAfterCreatingNew()
    {
        $schema1 = VF_Schema::create('foo,bar');
        $schema2 = new VF_Schema;
        $this->assertEquals(array('make','model','option','year'),$schema2->getLevels(), 'should get default schemas levels after creating new');
    }
    
    function testGetNewSchemasLevels()
    {
        $schema1 = VF_Schema::create('foo,bar');
        $schema2 = new VF_Schema;
        $this->assertEquals(array('foo','bar'),$schema1->getLevels(), 'should get new schemas levels');
    }
}