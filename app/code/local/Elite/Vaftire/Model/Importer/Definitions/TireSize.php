<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Elite_Vaftire_Model_Importer_Definitions_TireSize extends VF_Import_VehiclesList_CSV_Import
{
    function importRow($row)
    {   
        $this->row_number++;
        $this->oldImportRow($row);
    }
    
    /**
    * @param array $row
    * @param VF_Vehicle|boolean the vehicle, false if none (for example, when setting a product as universal)
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