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
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Elite_Vaf_Model_MergeTests_PaintTest extends Elite_TestCase
{
    const NEWLINE = "\n";
    
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        
        $this->csvData = 'make,model,year,Code,Name,Color(hex)' . self::NEWLINE;
        $this->csvData .= 'Acura, Integra, 1986,  B-26MZ,  Avignon Blue Metallic Clearcoat, #9CBBCC' . self::NEWLINE;
        $this->csvData .= 'Acura, Integra, 1987,  B-38,  Capitol Blue, #061D72' . self::NEWLINE;
        $this->csvFile = TEMP_PATH . '/paint-definitions.csv';
        file_put_contents( $this->csvFile, $this->csvData );

        $importer = new Elite_Vafpaint_Model_Importer_Definitions_Paint( $this->csvFile );
        $importer->import();
    }
    
	/**
	 * @expectedException Elite_Vaf_Model_Merge_Exception_IncompatibleVehicleAttribute
	 */
	function testShouldPreventOperation()
    {
        $vehicle1 = $this->vehicleFinder()->findOneByLevels(array('make'=>'Acura', 'model'=>'Integra', 'year'=>'1986'));
        $vehicle2 = $this->vehicleFinder()->findOneByLevels(array('make'=>'Acura', 'model'=>'Integra', 'year'=>'1987'));
        
        $slaveLevels = array(
            array('year', $vehicle1 ),
            array('year', $vehicle2 ),
        );
        $masterLevel = array('year', $vehicle2 );
        
        $this->merge($slaveLevels, $masterLevel);
    }
    
	/**
	 * @expectedException Elite_Vaf_Model_Merge_Exception_IncompatibleVehicleAttribute
	 */
	function testShouldPreventOperation2()
    {
        $vehicle1 = $this->vehicleFinder()->findOneByLevels(array('make'=>'Acura', 'model'=>'Integra', 'year'=>'1986'));
        $vehicle2 = $this->createMMY();
        
        $slaveLevels = array(
            array('year', $vehicle1 ),
            array('year', $vehicle2 ),
        );
        $masterLevel = array('year', $vehicle2 );
        
        $this->merge($slaveLevels, $masterLevel);
    }
}