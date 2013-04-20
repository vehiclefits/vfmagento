<?php

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