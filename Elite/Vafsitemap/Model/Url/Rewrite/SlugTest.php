<?php

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