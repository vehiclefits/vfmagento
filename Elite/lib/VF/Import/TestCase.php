<?php
class VF_Import_TestCase extends Elite_Vaf_TestCase
{
    function getVehiclesListExport()
    {
        return new VF_Import_VehiclesList_CSV_Export;
    }
    
    function importVehiclesList($csvData)
    {
        $importer = $this->vehiclesListImporter($csvData);
        $importer->import();
        return $importer;
    }
    
    function importVehiclesListTwice( $file )
    {
        $this->importVehiclesList( $file );
        return $this->importVehiclesList( $file );
    }
    
    function vehiclesListImporter($csvData)
    {
        $file = TESTFILES . '/vehicles-list.csv';  
        file_put_contents( $file, $csvData );
        $importer = new VF_Import_VehiclesList_CSV_Import( $file );
        return $importer;
    }
}