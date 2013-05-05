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
require_once('config.php');


// Edit: set to store ID to run export for
$storeId = 1;


// DO NOT EDIT BELOW HERE

$sitemap = new Elite_Vafsitemap_Model_Sitemap_Product_XML();
$size = $sitemap->fitmentCount($storeId);

$files = array();
$chunkSize = 50000;

$basePath = Mage::getBaseDir() . '/var/vaf-sitemap-xml';

@mkdir($basePath);

for( $i=0; $i<=$size; $i+=$chunkSize )
{
    $xml = $sitemap->xml($storeId, $i==0?0:$i+1, $i+$chunkSize );
    $file = $basePath.'/'.floor($i/$chunkSize).'.xml';
    array_push($files,basename($file));
    file_put_contents($file, $xml);
}
file_put_contents($basePath.'/sitemap-index.xml',$sitemap->sitemapIndex($files));
echo 'Sitemap created to ' . $basePath;
exit();