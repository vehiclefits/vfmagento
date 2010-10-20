<?php
abstract class Elite_Vafnote_Observer_Importer_MappingsTests_TestCase extends Elite_Vafimporter_Model_ProductFitments_CSV_ImportTests_TestCase
{
    function import($stringData)
    {
        $file = TESTFILES . '/mappings.csv';
        file_put_contents( $file, $stringData );
        $importer = new Elite_Vafimporter_Model_ProductFitments_CSV_Import_TestSubClass( $file );
        $importer->import();
    }
}