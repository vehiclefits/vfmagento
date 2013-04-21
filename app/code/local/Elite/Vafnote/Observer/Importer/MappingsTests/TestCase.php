<?php
abstract class Elite_Vafnote_Observer_Importer_MappingsTests_TestCase extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{
    function import($stringData)
    {
        $file = TEMP_PATH . '/mappings.csv';
        file_put_contents( $file, $stringData );
        $importer = new VF_Import_ProductFitments_CSV_Import_TestSubClass( $file );
        $importer->import();
    }
}