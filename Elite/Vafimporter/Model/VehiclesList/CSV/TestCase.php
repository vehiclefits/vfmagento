<?php
class Elite_Vafimporter_Model_VehiclesList_CSV_TestCase extends Elite_Vafimporter_TestCase
{
    function getDefinitionsImport($file)
    {
        return $this->getDefinitions($file);
    }
    
    function getDefinitions($file)
    {
        return $this->getDefinitionsCsv($file);
    }
    
    function getDefinitionsExport()
    {
        return new Elite_Vafimporter_Model_VehiclesList_CSV_Export;
    }
    
    function importVehiclesList($csvData)
    {
        $importer = $this->vehiclesListImporter($csvData);
        $importer->import();
    }
    
    function vehiclesListImporter($csvData)
    {
        $file = TESTFILES . '/vehicles-list.csv';  
        file_put_contents( $file, $csvData );
        $importer = $this->getDefinitions( $file );
        return $importer;
    }
}
