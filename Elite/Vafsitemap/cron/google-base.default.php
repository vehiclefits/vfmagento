<?php
require_once('config.php');


// Edit: set to store ID to run export for
$storeId = 1;


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