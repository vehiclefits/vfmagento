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
class Elite_Vafsitemap_Model_Sitemap_Product_XML extends Elite_Vafsitemap_Model_Sitemap_Product
{
    function xml( $storeId, $startRecord, $endRecord )
    {
        $this->storeId = $storeId;

        $return = '<?xml version="1.0" encoding="UTF-8"?>';
        $return .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        $record = $startRecord;
        
        $query = VF_Singleton::getInstance()->getReadAdapter()->select()
		->from($this->getProductTable(), array('entity_id'));
	$rs = $query->query();
	while($productRow = $rs->fetch())
	{
	    $product = $this->loadProduct($productRow['entity_id']);
	    if( !in_array($storeId, $product->getStoreIds()) )
	    {
		continue;
	    }

            echo 'product - ' . $product->getId() . "\n";
            foreach( $product->getFitModels() as $vehicle )
            {
                echo '    definition - ' . implode('-',$vehicle->toTitleArray() ) . "\n";
                $record++;
                if( $record >= $startRecord && $record <= $endRecord )
                {
                    $product->setCurrentlySelectedFit( $vehicle );
                    $return .= $this->product($product);
                }
            }
        }
        
        $return .= '</urlset>';
        return $return;
    }

    function fitmentCount($storeId)
    {
        $query = VF_Singleton::getInstance()->getReadAdapter()->select()
		->from($this->getProductTable(), array('entity_id'));
	$rs = $query->query();
	while($productRow = $rs->fetch())
	{
	    $product = $this->loadProduct($productRow['entity_id']);
	    if( !in_array($storeId, $product->getStoreIds()) )
	    {
		continue;
	    }

            $count += count($product->getFitModels());
        }

        return $count;
    }

    function productCount()
    {
	$count = 0;
	$query = VF_Singleton::getInstance()->getReadAdapter()->select()
		->from($this->getProductTable(), array('entity_id'));
	$rs = $query->query();
	while($productRow = $rs->fetch())
	{
	    $product = $this->loadProduct($productRow['entity_id']);
	    if( !in_array($storeId, $product->getStoreIds()) )
	    {
		continue;
	    }
	    $count++;
	}
	return $count;
    }

    function getProductTable()
    {
        $resource = new Mage_Catalog_Model_Resource_Eav_Mysql4_Product;
        $table = $resource->getTable( 'catalog/product' );
        return $table;
    }
    
    function sitemapIndex($files)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach($files as $file)
        {
           $xml .= '<sitemap>';
              $xml .= '<loc>' . $this->baseUrl($_GET['store']) . $file . '</loc>';
           $xml .= '</sitemap>';
        }
        $xml .= '</sitemapindex>';
        return $xml;
    }
    
    function product($product)
    {
        $return = '<url>';
        $return .= '<loc>'.$this->productUrl($product).'</loc>';
        $return .= '</url>';
        return $return;
    }

    function loadProduct($id)
    {
	$product = Mage::getModel('catalog/product')
		->setStoreId($this->storeId)
		->load($id);
	return $product;
    }
    
}