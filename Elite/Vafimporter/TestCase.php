<?php
class Elite_Vafimporter_TestCase extends Elite_Vaf_TestCase
{
    function getDefinitionsCsv( $file )
    {
        $importer = new Elite_Vafimporter_Model_VehiclesList_CSV_Import( $file );
        return $importer;
    }
}