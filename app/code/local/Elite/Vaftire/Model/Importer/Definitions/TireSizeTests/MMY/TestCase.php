<?php
class Elite_Vaftire_Model_Importer_Definitions_TireSizeTests_MMY_TestCase extends Elite_Vaf_TestCase
{
    function importVehicleTireSizes($stringData)
    {
        $file = TESTFILES . '/bolt-definitions-range.csv';
        file_put_contents( $file, $stringData );
        $importer = new Elite_Vaftire_Model_Importer_Definitions_TireSize($file);
        $importer->import();
    }
    
    function findVehicleByLevelsMMY( $make, $model, $year )
    {
        $vehicle = parent::findVehicleByLevelsMMY($make,$model,$year);
        return new Elite_Vaftire_Model_Vehicle($vehicle);
    }
}