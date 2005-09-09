<?php
abstract class VF_Import_VehiclesList_XML_TestCase extends Elite_Vaf_TestCase
{
    function vehiclesListImporter( $file )
    {
        $importer = new VF_Import_VehiclesList_XML_Import( $file );
        return $importer;
    }
    
    function getDefinitionsData( $data )
    {
        $file = TESTFILES . '/definitions.xml';
        file_put_contents( $file, $data );
        
        $importer = new VF_Import_VehiclesList_XML_Import( $file );
        return $importer;
    }
}
