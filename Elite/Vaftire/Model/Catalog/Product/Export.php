<?php
class Elite_Vaftire_Model_Catalog_Product_Export
{
	function export()
	{
		$csv = '"sku","section_width","aspect_ratio","diameter"';
		$csv .= "\n";
		
		foreach($this->getCollection() as $product)
		{
			$product = new Elite_Vaftire_Model_Catalog_Product($product);
			if($product->getTireSize())
			{
				$tireSize = $product->getTireSize();
				
				$csv .= '"'.$product->getSku().'",';
				$csv .= '"'.$tireSize->sectionWidth().'",';
				$csv .= '"'.$tireSize->aspectRatio().'",';
				$csv .= '"'.$tireSize->diameter().'"';
				$csv .= "\n";
			}
		}
		
		return $csv;
	}
	
	function getCollection()
    {
        $collection = new Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection;
        $collection->addAttributeToSelect('*');
        
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
//        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
        return $collection;
    }
}