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
class VF_SchemaTests_MMY_NextLevelsTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }
    
    function testNextLevelsYear()
    {
        $schema = new VF_Schema(); 
        $this->assertEquals( array(), $schema->getNextLevels('year') );
    }
    
    function testNextLevelsModel()
    {
        $schema = new VF_Schema(); 
        $this->assertEquals( array('year'), $schema->getNextLevels('model') );
    }
    
    function testNextLevelsMake()
    {
        $schema = new VF_Schema(); 
        $this->assertEquals( array('model','year'), $schema->getNextLevels('make') );
    }
}