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
require_once( dirname( __FILE__ ).'/config.default.php');
require_once( getenv('PHP_MAGE_PATH').'/app/Mage.php' );
require_once( dirname( __FILE__ ) . '/../Vaf/bootstrap.php' );
Mage::app();

class SampleData
{
    protected $fields;
    
    protected $i = 0;
    
    const SKU = 5;
    const name = 7;
    const urlKey = 13;
    const urlPath = 14;
    const productName = 591;
    
    function main()
    {
        $newCsv = '';
        $newCsv .= "sku,make,model,year\n";
        for( $this->i = 1; $this->i <= 300; $this->i++ )
        {
             $line = "";
             $line .= 'YJSU-20';
             $line .= ",";
             $line .= 'make' . rand(1,25);
             $line .= ",";
             $line .= 'model' . rand(1,25);
             $line .= ",";

             $year = rand(1950,2010);
             $line .= $year;
            
             $newCsv .= $line . "\n";
        }

        $file = getenv('PHP_TEMP_PATH').'/sampleMappings.csv';
        file_put_contents($file,$newCsv);
        $importer = new VF_Import_ProductFitments_CSV_Import($file);
        $importer->import();
        echo "data imported\n";
    }

    function newSku()
    {
        return 'sku'.$this->i;
    }
    
    function newName()
    {
        return 'product'.$this->i;
    }
    
    function newUrlKey()
    {
        return 'product'.$this->i;
    }

}

$cli = new SampleData();
$cli->main();