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
class VF_AjaxTests_MultipleSchemaTest extends Elite_Vaf_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
    }

    function testShouldListRootLevel_WhenCalledFromFrontend()
    {
        $schema = VF_Schema::create('foo,bar');
        $vehicle = $this->createVehicle(array('foo'=>'123','bar'=>'456'), $schema);

        $mapping = new VF_Mapping(1,$vehicle);
        $mapping->save();

        ob_start();
        $_GET['front']=1;
        $_GET['requestLevel'] = 'foo';
        $ajax = new VF_Ajax();
        $ajax->execute( $schema );
        $actual = ob_get_clean();

        $this->assertEquals( '<option value="' . $vehicle->getValue('foo') . '">123</option>', $actual, 'should list root levels from 2nd schema' );
    }

    function testShouldListChildLevel_WhenCalledFromFrontend()
    {
        $schema = VF_Schema::create('foo,bar');
        $vehicle = $this->createVehicle(array('foo'=>'123','bar'=>'456'), $schema);

        $mapping = new VF_Mapping(1,$vehicle);
        $mapping->save();

        ob_start();
        $_GET['front']=1;
        $_GET['requestLevel'] = 'bar';
        $_GET['foo'] = $vehicle->getValue('bar');
        $ajax = new VF_Ajax();
        $ajax->execute( $schema );
        $actual = ob_get_clean();

        $this->assertEquals( '<option value="' . $vehicle->getValue('bar') . '">456</option>', $actual, 'should list child levels from 2nd schema' );
    }

    function testShouldListChildLevel_WhenCalledFromBackend()
    {
        $schema = VF_Schema::create('foo,bar');
        $vehicle = $this->createVehicle(array('foo'=>'123','bar'=>'456'), $schema);

        $mapping = new VF_Mapping(1,$vehicle);
        $mapping->save();

        ob_start();
        $_GET['requestLevel'] = 'bar';
        $_GET['foo'] = $vehicle->getValue('bar');
        $ajax = new VF_Ajax();
        $ajax->execute( $schema );
        $actual = ob_get_clean();

        $this->assertEquals( '<option value="' . $vehicle->getValue('bar') . '">456</option>', $actual, 'should list child levels from 2nd schema' );
    }
}