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
class Elite_Vafwheel_Model_Importer_Definitions_Bolts extends VF_Import_VehiclesList_CSV_Import
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
        $boltPattern = $this->getFieldValue( 'bolt_pattern', $row );
        $offset = $this->getFieldValue( 'offset', $row );
        $boltPattern = Elite_Vafwheel_Model_BoltPattern::create($boltPattern, $offset);
        $wheelDefinition = new Elite_Vafwheel_Model_Vehicle($vehicle);
        $wheelDefinition->addBoltPattern($boltPattern);
    }
 
}