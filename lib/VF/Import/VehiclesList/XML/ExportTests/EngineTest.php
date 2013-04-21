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
class VF_Import_VehiclesList_XML_ExportTests_EngineTest extends VF_Import_VehiclesList_XML_TestCase
{
    protected $csvData;
    protected $csvFile;

    function doSetUp()
    {
        $this->csvData = '<?xml version="1.0" encoding="UTF-8"?>   
<vehicles version="1.0">
    <definition>
        <year id="8">2000</year>
        <make id="4">Honda</make>
        <model id="5">Civic</model>
        <submodel id="16">EX</submodel>
        <engine id="85">EX</engine>
    </definition>        
</vehicles>';
        $this->csvFile = TEMP_PATH . '/definitions.xml';
        file_put_contents( $this->csvFile, $this->csvData );
        
        $this->switchSchema('year,make,model,submodel,engine');
        
        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();
    }
    
    function testImportsMakeTitle()
    {
        $exporter = new VF_Import_VehiclesList_XML_Export;
                   
        $this->assertEquals( '<?xml version="1.0"?>
<vehicles version="1.0">
    <definition>
        <year id="8">2000</year>
        <make id="4">Honda</make>
        <model id="5">Civic</model>
        <submodel id="16">EX</submodel>
        <engine id="85">EX</engine>
    </definition>
</vehicles>', $exporter->export() );
    }
    
    /** @todo testIfIdIsNotAvailable */
    function testIfIdIsNotAvailable()
    {
        return $this->markTestIncomplete();
    }
    
}
