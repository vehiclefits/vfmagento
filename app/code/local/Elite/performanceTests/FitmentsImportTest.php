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
class Elite_performanceTests_FitmentsImportTest extends VF_Import_ProductFitments_CSV_ImportTests_TestCase
{
    function doSetUp()
    {
        $this->switchSchema('make,model,year');
        $this->createHugeFile();
    }
    
    function testShouldImportLargeAmountOfFitments()
    {
        $this->setMaxRunningTime(120);
        $command = ELITE_PATH . '/bin/vfmagento '.$this->csvFile();
        exec($command,$output,$return_code);
        $this->assertEquals(0,$return_code);
    }

    function createHugeFile()
    {
        $file = $this->csvFile();
        $h = fopen($file,'w');
        fwrite($h,"sku,year,make,model\n");
        for($i=0;$i<=100000;$i++)
        {
            $sku = 'sku'.rand(1,1000);
            $year = rand(1990,2013);
            $make = 'make'.rand(1,50);
            $model = 'model'.rand(1,500);
            fwrite($h,"$sku,$year,$make,$model\n");
        }
    }
    
    function csvFile()
    {
        return sys_get_temp_dir().'/FitmentsImportTest.csv';
    }

}
