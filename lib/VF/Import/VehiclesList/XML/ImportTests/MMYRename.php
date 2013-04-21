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
class VF_Import_VehiclesList_XML_ImportTests_MMYRenameTest extends VF_Import_VehiclesList_XML_TestCase
{
    protected $csvData;
    protected $csvFile;

    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        
        
        $this->csvData = '<?xml version="1.0" encoding="UTF-8"?>   
<vehicles>
    <definition id="1">
        <make id="4">Honda</make>
        <model id="5">Civic</model>
        <year id="8">2000</year>
    </definition>        
</vehicles>';
        $this->csvFile = TEMP_PATH . '/definitions.xml';
        file_put_contents( $this->csvFile, $this->csvData );

        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();  
        
           
              
        $this->csvData = '<?xml version="1.0" encoding="UTF-8"?>   
<vehicles>
    <definition id="1">
        <make id="4">HondaRENAMED</make>
        <model id="5">Civic</model>
        <year id="8">2000</year>
    </definition>        
</vehicles>';
        $this->csvFile = TEMP_PATH . '/definitions.xml';
        file_put_contents( $this->csvFile, $this->csvData );

        $importer = $this->vehiclesListImporter( $this->csvFile );
        $importer->import();
    }
    
    function testRenames()
    {
        
        $this->assertFalse( $this->entityTitleExists( 'make', 'Honda' ), 'should be able to rename a make' );
        $this->assertTrue( $this->entityTitleExists( 'make', 'HondaRENAMED' ), 'should be able to rename a make' );
    }
    
}