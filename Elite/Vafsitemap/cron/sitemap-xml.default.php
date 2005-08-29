<?php
require_once('config.php');


// Edit: set to store ID to run export for
$storeId = 1;


// DO NOT EDIT BELOW HERE

$sitemap = new Elite_Vafsitemap_Model_Sitemap_Product_XML();
$size = $sitemap->getCollectionSize();
$files = array();
$chunkSize = 50000;
//$basePath = Mage::getBaseDir() . '/var/vaf-sitemap-xml';
$basePath = 'vaf-sitemap-xml';
if(file_exists($basePath))
{
    $this->recursiveDelete($basePath);
}
mkdir($basePath);

for( $i=0; $i<=$size; $i+=$chunkSize )
{
    $xml = $sitemap->xml($_GET['store'], $i==0?0:$i+1, $i+$chunkSize );
    $file = $basePath.'/'.floor($i/$chunkSize).'.xml';
    array_push($files,basename($file));
    file_put_contents($file, $xml);
}
file_put_contents($basePath.'/sitemap-index.xml',$sitemap->sitemapIndex($files));
echo 'Sitemap created to ' . $basePath;
exit();