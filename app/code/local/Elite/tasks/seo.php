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
// Edit: set paths as neccessary
require_once( dirname( __FILE__ ) . '/../Vaf/bootstrap.php' );
require_once('../../../../Mage.php');

// Edit: set to store ID to run export for
$storeId = 1;

// Edit: Set to database credentials (should match app/etc/local.xml and empty cache) 
$params = array(
    'host'           => '',
    'username'       => 'root',
    'password'       => 'vaf',
    'dbname'         => 'vaf'
);




// DO NOT EDIT BELOW HERE
// DO NOT EDIT BELOW HERE
// DO NOT EDIT BELOW HERE

$db = Zend_Db::factory('pdo_mysql', $params);
$db->getConnection();
Zend_Registry::set('db',$db);

$sitemap = new Elite_Vafsitemap_Model_Sitemap_Product_GoogleBase();

$csv = $sitemap->csv($storeId,true);
$file = 'google-base-store-'.$storeId.'.csv';
file_put_contents($file,$csv);
echo 'sitemap saved to ' . $file;
exit();