<?php
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