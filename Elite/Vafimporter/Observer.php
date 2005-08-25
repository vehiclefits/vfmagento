<?php
interface Vafimporter_Observer
{
    /**
    * @param array $fields
    * @param array $row
    * @param VF_Vehicle the vehicle
    */
    function doImportRow( $fields, $row, VF_Vehicle $vehicle );
}