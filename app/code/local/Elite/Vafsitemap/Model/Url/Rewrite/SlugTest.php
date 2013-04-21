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

class Vafsitemap_Model_Url_Rewrite_SlugTest extends Elite_Vaf_TestCase
{

    function testSlugToVehicle()
    {
	$this->createMMY('Honda', 'Civic', '2000');
	$slug = 'Honda~Civic~2000';
	$vehicle = $this->slug()->slugToVehicle($slug);
	$this->assertEquals('Honda Civic 2000', $vehicle->__toString());
    }

    function testShouldConvertDashToSpace()
    {
	$this->createMMY('Honda', 'All Models', '2000');
	$slug = 'Honda~All-Models~2000';
	$vehicle = $this->slug()->slugToVehicle($slug);
	$this->assertEquals('Honda All Models 2000', $vehicle->__toString(), 'should convert dash to space');
    }

    function testShouldUseMixedDash_DifferentFields()
    {
	$this->createMMY('All-Makes', 'All Models', '2000');
	$slug = 'All-Makes~All-Models~2000';
	$vehicle = $this->slug()->slugToVehicle($slug);
	$this->assertEquals('All-Makes All Models 2000', $vehicle->__toString(), 'when there are mixed dashes & spaces, should find the right vehicle');
    }

    function testShouldEncodeAmperstand()
    {
	$this->createMMY('All & Makes', 'All Models', '2000');
	$slug = 'All-%26-Makes~All-Models~2000';
	$vehicle = $this->slug()->slugToVehicle($slug);
	$this->assertEquals('All & Makes All Models 2000', $vehicle->__toString(), 'should urlencode amperstands');
    }

    function testShouldUseMixedDash_WithinModel()
    {
	$this->createMMY('F-or d', 'F-150 Super Duty', '2000');
	$slug = 'F-or-d~F-150-Super-Duty~2000';
	$vehicle = $this->slug()->slugToVehicle($slug);
	$this->assertEquals('F-or d F-150 Super Duty 2000', $vehicle->__toString(), 'when there are mixed dashes & spaces, should find the right vehicle');
    }

    function slug()
    {
	return new Vafsitemap_Model_Url_Rewrite_Slug();
    }

}