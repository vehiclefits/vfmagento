<?php
class Elite_Vafsitemap_Model_Sitemap_Product_GoogleBase extends Elite_Vafsitemap_Model_Sitemap_Product
{
	function csv($storeId,$output=false)
	{
		$this->storeId = $storeId;
		$products = $this->getCollection();

		$return = $this->fieldNames();
        
        foreach( $products as $product )
		{
			$product = Mage::getModel('catalog/product')
	            ->setStoreId($this->storeId)
	            ->load($product->getId());
            
            echo 'product - ' . $product->getId() . "\n";
			foreach( $product->getFitModels() as $vehicle )
			{
				echo '    definition - ' . implode('-',$vehicle->toTitleArray() ) . "\n";
				$product->setCurrentlySelectedFit( $vehicle );
				$return .= $this->row($product,$vehicle);              
			}
		}
		
		return $return;
	}
	
	function fieldNames()
	{
		$return = 'id';
        $return .=  "\t";
        $return .= 'title';
		$return .=  "\t";
		$return .=  'description';
		$return .=  "\t";
		$return .=  'price';
		$return .=  "\t";
		$return .=  'link';
		$return .=  "\t";
		$return .=  'condition';
		$return .=  "\t";
        $return .=  'image_link';
        $return .=  "\t";
		$return .=  'product type';
		$return .=  "\n";
		return $return;
	}
	
	function row($product,$vehicle)
	{
		$return =  $product->getId() . '-' . implode('-',$vehicle->toValueArray());
        $return .=  "\t";
        $return .=  $product->getName();
		$return .=  "\t";
		$return .=  $this->description($product->getShortDescription());
		$return .=  "\t";
		$return .=  number_format($this->price($product),2);
		$return .=  "\t";
		$return .=  $this->productUrl($product);
		$return .=  "\t";
		$return .=  'new';
        $return .=  "\t";
        $return .=  $this->productImageUrl($product);
		$return .=  "\t";
		$return .=  $this->categoryPath($product);
		
		$return .=  "\n";
		return $return;
	}
	
	function price($product)
	{
		if( $product->getTypeInstance(true) instanceof Mage_Bundle_Model_Product_Type )
		{
			list($miniminalPrice, $maximalPrice) = $product->getPriceModel()->getPrices($product);
			return $miniminalPrice;
		}
		return $product->getFinalPrice();
	}
	
	function productImageUrl($product)
	{
		if ($product->getImage() == 'no_selection' || !$product->getImage())
        {
            return;
        }
        return Mage::helper('catalog/image')->init($product, 'image');
	}
    
    function categoryPath($product)
    {
        $names = array();
        foreach($this->categoryPathArray($product) as $category)
        {
            $names[] = $category->getName();
        }
        $names = array_reverse($names);
        return implode(' > ', $names);
    }
    
    function categoryPathArray($product)
    {
        $categories = $product->getCategoryIds();
        
        $categoryId = current($categories);
        $category = $this->categoryById($categoryId);
        
        $path = array( $category );
        while($parentId = $category->getParentId())
        {
            $parent = $this->categoryById($parentId);
            // if is the "default category" or "root catalog"
            if($parent->getLevel() <= 1)
            {
                break;
            }
            $path[] = $parent;
            $category = $parent;
        }
        
        return $path;
    }
    
    function description($originalDescription)
    {
        return strip_tags(str_replace(array("\r","\n","\r\n"),"",$originalDescription));
    }
    
    function categoryById($categoryId)
    {
        return Mage::getModel('catalog/category')->load($categoryId);
    }
	
}
