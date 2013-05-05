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

class Elite_Vafsitemap_Admin_VafsitemapController extends Mage_Adminhtml_Controller_Action
{

    function exportAction()
    {
	$this->checkVersion();

	if (isset($_REQUEST['go']))
	{
	    if (isset($_REQUEST['format']) && 'csv' == $_REQUEST['format'])
	    {
		header(sprintf('Content-Disposition: attachment;filename="vaf-export-%s.csv"', time()));
		$stream = fopen("php://output", 'w');
		$sitemap = new Elite_Vafsitemap_Model_Sitemap_Product_GoogleBase($this->config());
		$sitemap->csv($_GET['store'], $stream);
		exit();
	    } else
	    {
		$sitemap = new Elite_Vafsitemap_Model_Sitemap_Product_XML($this->config());
		$size = $sitemap->productCount();
		$files = array();
		$chunkSize = 50000;
		$basePath = Mage::getBaseDir() . '/var/vaf-sitemap-xml';
		if (file_exists($basePath))
		{
		    $this->recursiveDelete($basePath);
		}
		mkdir($basePath);

		for ($i = 0; $i <= $size; $i+=$chunkSize)
		{
		    $xml = $sitemap->xml($_GET['store'], $i == 0 ? 0 : $i + 1, $i + $chunkSize);
		    $file = $basePath . '/' . floor($i / $chunkSize) . '.xml';
		    array_push($files, basename($file));
		    file_put_contents($file, $xml);
		}
		file_put_contents($basePath . '/sitemap-index.xml', $sitemap->sitemapIndex($files));
		echo 'Sitemap created to ' . $basePath;
		exit();
	    }
	}

	$this->loadLayout();
	$this->_setActiveMenu('vaf/export');

	$block = $this->getLayout()->createBlock('adminhtml/template', 'vafsitemap_export')->setTemplate( 'vf/vafsitemap/export.phtml');
	$this->_addContent($block);
	$this->renderLayout();
    }

    function config()
    {
	return VF_Singleton::getInstance()->getConfig();
    }

    protected function checkVersion()
    {
	$version = new Elite_Vafinstall_Migrate;
	if ($version->needsUpgrade())
	{
	    echo 'Please run the upgrade-vaf.php script as per the documentation. Your database is out of date.';
	    exit();
	}
    }

    /**
     * Delete a file or recursively delete a directory
     *
     * @param string $str Path to file or directory
     */
    function recursiveDelete($str)
    {
	if (is_file($str))
	{
	    return @unlink($str);
	} elseif (is_dir($str))
	{
	    $scan = glob(rtrim($str, '/') . '/*');
	    foreach ($scan as $index => $path)
	    {
		$this->recursiveDelete($path);
	    }
	    return @rmdir($str);
	}
    }

}
