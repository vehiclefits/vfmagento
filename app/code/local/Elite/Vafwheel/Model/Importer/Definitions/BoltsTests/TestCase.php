<?php
abstract class Elite_Vafwheel_Model_Importer_Definitions_BoltsTests_TestCase extends Elite_Vaf_TestCase
{
    function importVehicleBolts($stringData)
    {
        $csvFile = TEMP_PATH . '/bolt-definitions.csv';
        file_put_contents( $csvFile, $stringData );
        $importer = new Elite_Vafwheel_Model_Importer_Definitions_Bolts( $csvFile );
        $importer->import();
    }
    
    function findVehicleByLevelsMMY( $make, $model, $year )
    {
        $vehicle = parent::findVehicleByLevelsMMY($make,$model,$year);
        return new Elite_Vafwheel_Model_Vehicle($vehicle);
    }
    
    function findVehicleByLevelsYMM( $year, $make, $model )
    {
        $vehicle = parent::findVehicleByLevelsYMM($year,$make,$model);
        return new Elite_Vafwheel_Model_Vehicle($vehicle);
    }
    
    function findVehicleByLevelsMMOY( $make, $model, $option, $year )
    {
        $vehicle = parent::findVehicleByLevelsMMOY($make,$model,$option,$year);
        return new Elite_Vafwheel_Model_Vehicle($vehicle);
    }
    
}