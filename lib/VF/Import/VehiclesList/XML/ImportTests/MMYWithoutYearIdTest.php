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
class VF_Import_VehiclesList_XML_ImportTests_MMYWithoutYearIdTest extends VF_Import_VehiclesList_XML_TestCase
{
    protected $csvData;
    protected $csvFile;

    function doSetUp()
    {
        $this->csvData = '<?xml version="1.0" encoding="UTF-8"?>   
<vehicles>
    <definition id="1">
        <make id="4">Honda</make>
        <model id="5">Civic</model>
        <year>2000</year>
    </definition>        
</vehicles>';
        $this->csvFile = TEMP_PATH . '/definitions.xml';
        file_put_contents( $this->csvFile, $this->csvData );
        
        $this->switchSchema('make,model,year');
    }
    
    function testDoesntImportBlank()
    {
        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();
        $this->assertFalse( $this->vehicleExists(array('make'=>'')), 'should not import a blank make' );
    }
    
    function testImportsMakeTitle()
    {
        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();
        $this->assertTrue( $this->vehicleExists(array('make'=>'Honda')), 'should import a make title' );
    }
    
    function testImportsModelTitle()
    {
        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();
        $this->assertTrue( $this->vehicleExists(array('model'=>'Civic')), 'should import a model title' );
    }
    
    function testImportsYearTitle()
    {
        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();
        $this->assertTrue( $this->vehicleExists(array('year'=>'2000')), 'should import a year title' );
    }
    
    function testImportsMakeId()
    {
        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();
        $this->assertEquals( 4, $this->levelFinder()->find('make',4)->getId(), 'imports the makeID #' );
    }
    
    function testImportsModelId()
    {
        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();
        $this->assertEquals( 5, $this->levelFinder()->find('model',5)->getId(), 'imports the modelID #' );
    }

}