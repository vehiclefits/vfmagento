<?php
interface Vafimporter_Observer
{
    /**
    * @param array $fields
    * @param array $row
    * @param Elite_Vaf_Model_Vehicle the vehicle
    */
    function doImportRow( $fields, $row, Elite_Vaf_Model_Vehicle $vehicle );
}