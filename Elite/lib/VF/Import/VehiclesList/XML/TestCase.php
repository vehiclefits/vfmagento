<?php
abstract class Elite_Vafimporter_Model_VehiclesList_XML_TestCase extends Elite_Vaf_TestCase
{
    function vehiclesListImporter( $file )
    {
        $importer = new Elite_Vafimporter_Model_VehiclesList_XML_Import( $file );
        return $importer;
    }
    
    function getDefinitionsData( $data )
    {
        $file = TESTFILES . '/definitions.xml';
        file_put_contents( $file, $data );
        
        $importer = new Elite_Vafimporter_Model_VehiclesList_XML_Import( $file );
        return $importer;
    }
}
