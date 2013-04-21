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
class VF_Import_VehiclesList_XML_Export extends VF_Import_VehiclesList_BaseExport
{
    const EOL = "\n";
    
    function export()
    {

$xml = '<?xml version="1.0"?>'.self::EOL;
$xml .= '<vehicles version="1.0">'.self::EOL;
        
        $rowResult = $this->rowResult();
        
        while( $vehicleRow = $rowResult->fetch(Zend_Db::FETCH_OBJ) )
        {

$xml .= '    <definition>'.self::EOL;
            foreach($this->schema()->getLevels() as $level )
            {
$xml .= '        '.$this->renderLevel($level,$vehicleRow);
            }
$xml .= '    </definition>'.self::EOL;
            
        }
$xml .= '</vehicles>';

        return( $xml );
    }
    
    function renderLevel($level,$vehicleRow)
    {
        $id = $vehicleRow->{$level.'_id'};
        $title = $vehicleRow->$level;
        return '<'.$level.' id="'.$id.'">'.$title.'</'.$level.'>'.self::EOL;
    }
}