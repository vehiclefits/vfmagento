<?php
class Elite_Vaftire_Model_Importer_Definitions_TireSize extends Elite_Vafimporter_Model_VehiclesList_CSV_Import
{
    function importRow($row)
    {   
        $this->row_number++;
        $this->oldImportRow($row);
    }
    
    /**
    * @param array $row
    * @param Elite_Vaf_Model_Vehicle|boolean the vehicle, false if none (for example, when setting a product as universal)
    */
    function doImportRow( $row, $vehicle )
    {
        if(!$vehicle)
        {
            return;
        }
        $tireVehicle = new Elite_Vaftire_Model_Vehicle($vehicle);
        $tireSize = $this->tireSize($row);
        if(!$tireSize)
        {
            return false;
        }
        $tireVehicle->addTireSize($tireSize);
    }
    
    /** @return Elite_Vaftire_Model_TireSize|boolean tire size, or false if formatting was invalid */
    function tireSize($row)
    {
        try
        {
            $tireSizeString = $this->getFieldValue( 'tire_size', $row );
            $tireSize = Elite_Vaftire_Model_TireSize::create($tireSizeString);
        }
        catch( Elite_Vaftire_Model_TireSize_InvalidFormatException $e )
        {
            return false;
        }
        return $tireSize;
    }
}