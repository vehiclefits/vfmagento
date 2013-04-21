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
class Elite_performanceTests_FitmentsImportTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{
    function doSetUp()
    {
        
    }
    
    protected function doTearDown()
    {
	ini_set('memory_limit','256M');
    }
    
    function testShouldImport1kProductsInTenSeconds()
    {
        ini_set('memory_limit','512M');
        $this->switchSchema('make,model,year');
        $this->setMaxRunningTime(10);
        $this->mappingsImportFromFile($this->csvFile());
    }
    
    function testMemory()
    {
        ini_set('memory_limit','64M');
        $this->switchSchema('model,year',true);
        $this->mappingsImportFromFile($this->csvFile());
    }
    
    function csvFile()
    {
        return dirname(__FILE__).'/FitmentsImportTest.csv';
    }

}
