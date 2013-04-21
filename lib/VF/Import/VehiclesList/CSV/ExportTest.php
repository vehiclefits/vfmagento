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

class VF_Import_VehiclesList_CSV_ExportTest extends VF_Import_TestCase
{

    protected function doSetUp()
    {
	$this->switchSchema('make,model,year');
	$this->importVehiclesList('make, model, year
honda, civic, 2000
honda, civic, 2001
acura,integra,2000
acura,integra,2004');
    }

    function testExport()
    {
	$data = $this->exportVehiclesList();
	$output = explode("\n", $data);
	$this->assertEquals('make,model,year', $output[0]);
    }

    function exportVehiclesList()
    {
	$stream = fopen("php://temp", 'w');
	$exporter = $this->getVehiclesListExport();
	$exporter->export($stream);
	rewind($stream);

	$data = stream_get_contents($stream);
	return $data;
    }

}