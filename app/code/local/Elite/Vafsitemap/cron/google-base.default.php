<?php
$storeId = 1; // Edit: set to store ID to run export for

require_once('config.php');
$stream = fopen("php://output", 'w');
$sitemap = new Elite_Vafsitemap_Model_Sitemap_Product_GoogleBase();
$sitemap->csv($storeId,$stream);