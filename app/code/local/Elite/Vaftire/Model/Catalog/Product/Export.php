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
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.

 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Elite_Vaftire_Model_Catalog_Product_Export
{

    function export($stream)
    {
	fwrite($stream, '"sku","section_width","aspect_ratio","diameter"');
	fwrite($stream,  "\n");

	foreach ($this->getProductRows() as $productRow)
	{
	    $product = new Elite_Vaf_Model_Catalog_Product;
	    $product->setId($productRow['entity_id']);
	    
	    $product = new Elite_Vaftire_Model_Catalog_Product($product);
	    if ($product->getTireSize())
	    {
		$tireSize = $product->getTireSize();

		fwrite($stream, '"' . $productRow['sku'] . '",');
		fwrite($stream, '"' . $tireSize->sectionWidth() . '",');
		fwrite($stream, '"' . $tireSize->aspectRatio() . '",');
		fwrite($stream, '"' . $tireSize->diameter() . '"');
		fwrite($stream, "\n" );
	    }
	}
    }

    function getProductRows()
    {
	$query = Elite_Vaf_Helper_Data::getInstance()->getReadAdapter()->select()
		->from($this->getProductTable(), array('entity_id','sku'));
	$rs = $query->query();
	$ids = array();
	while($productRow = $rs->fetch())
	{
	    array_push($ids, $productRow);
	}
	return $ids;
    }

    function getProductTable()
    {
        $resource = new Mage_Catalog_Model_Resource_Eav_Mysql4_Product;
        $table = $resource->getTable( 'catalog/product' );
        return $table;
    }

}