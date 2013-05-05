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
require_once(dirname(__FILE__).'/../../tasks/config.default.php');

require_once( getenv('PHP_MAGE_PATH') . '/app/code/local/Elite/Vaf/bootstrap.php' );
require_once( getenv('PHP_MAGE_PATH') . '/app/Mage.php');
Mage::app('admin')->setUseSessionInUrl(false);

if(!isset($argv[1])) {
    echo 'Try product-fitments-import.php <filename>'."\n";
    exit;
}
$file = $argv[1];
$writer = new Zend_Log_Writer_Stream('product-fitments-import.csv.log');
$log = new Zend_Log($writer);
$importer = new VF_Import_ProductFitments_CSV_Import($file);
$importer->setLog($log);
$importer->import();