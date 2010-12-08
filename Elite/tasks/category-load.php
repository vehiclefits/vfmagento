<?php
require_once('../../../../Mage.php');
Mage::app('admin')->setUseSessionInUrl(false);

$csv = new Csv_Reader('ekow-products.csv');

echo 'discovering unique categories' . "\n";

$top_level_categories = array();
$sub1_categories = array();
$sub2_categories = array();
$sub3_categories = array();

$i = 0;
while($row = $csv->getRow())
{
    if(0===$i)
    {
        $i++;
        continue;
    }
    $i++;

	foreach($row as &$val)
	{
		$val = trim($val);
	}

    if(!in_array(trim($row[1]),$top_level_categories))
    {
        $top_level_categories[] = trim($row[1]);
        asort($top_level_categories);
	}
	

	if($row[2] && !in_array(trim($row[2]),$sub1_categories[$row[1]]))
	{
		$sub1_categories[trim($row[1])][] = trim($row[2]);
		asort($sub1_categories[trim($row[1])]);
	}

	if($row[3] && !in_array(trim($row[3]),$sub2_categories[$row[1]][$row[2]]))
	{
		$sub2_categories[trim($row[1])][trim($row[2])][] = trim($row[3]);
		asort($sub2_categories[trim($row[1])][trim($row[2])]);
	}

	if($row[4] && !in_array(trim($row[4]),$sub3_categories[$row[1]][$row[2]][$row[3]]))
	{
		$sub3_categories[trim($row[1])][trim($row[2])][trim($row[3])][] = trim($row[4]);
		asort($sub3_categories[trim($row[1])][trim($row[2])][trim($row[3])]);
	}
    
}

echo 'creating categories' . "\n";

$idsByTitle = array();

$baseData['general']['path'] = 2;
$baseData['general']['name'] = "";
$baseData['general']['meta_title'] = "";
$baseData['general']['meta_description'] = "";
$baseData['general']['is_active'] = "1";
$baseData['general']['url_key'] = "";
$baseData['general']['display_mode'] = "PRODUCTS";
$baseData['general']['is_anchor'] = 1;

$baseData['category']['parent'] = 2;

foreach($top_level_categories as $top_level_category)
{
    $data = $baseData;
    $data['general']['name'] = $top_level_category;
    $storeId = 0;

    $top_level_id = createCategory($data,$storeId);
    $idsByTitle[$top_level_category] = array('id'=>$top_level_id);
    
    foreach($sub1_categories[$top_level_category] as $sub1_category)
    {
        $data = $baseData;
        $data['general']['name'] = $sub1_category;
        $data['category']['parent'] = $top_level_id;
        $data['general']['path'] = $top_level_id;
        $storeId = 0;

        $sub1_level_id = createCategory($data,$storeId);
        $idsByTitle[$top_level_category]['children'][$sub1_category] = array('id'=>$sub1_level_id);
        
        foreach($sub2_categories[$top_level_category][$sub1_category] as $sub2_category)
        {
            $data = $baseData;
            $data['general']['name'] = $sub2_category;
            $data['category']['parent'] = $sub1_level_id;
            $data['general']['path'] = $sub1_level_id;
            $storeId = 0;

            $sub2_level_id = createCategory($data,$storeId);
            $idsByTitle[$top_level_category]['children'][$sub1_category]['children'][$sub2_category] = array('id'=>$sub2_level_id);
            
            foreach($sub3_categories[$top_level_category][$sub1_category][$sub2_category] as $sub3_category)
            {
                $data = $baseData;
                $data['general']['name'] = $sub3_category;
                $data['category']['parent'] = $sub2_level_id;
                $data['general']['path'] = $sub2_level_id;
                $storeId = 0;

                $sub3_level_id = createCategory($data,$storeId);
                $idsByTitle[$top_level_category]['children'][$sub1_category]['children'][$sub2_category]['children'][$sub3_category] = array('id'=>$sub3_level_id);
                
            }
        }
    }
    
}

echo 'writing output CSV' . "\n";

$h = fopen('ekow-new.csv','w');
$csv->rewind();
while($row = $csv->getRow())
{
    $row[4] = $idsByTitle[trim($row[1])]['children'][trim($row[2])]['children'][trim($row[3])]['children'][$row[4]]['id'];
    $row[3] = $idsByTitle[trim($row[1])]['children'][trim($row[2])]['children'][trim($row[3])]['id'];
    $row[2] = $idsByTitle[trim($row[1])]['children'][trim($row[2])]['id'];
    $row[1] = $idsByTitle[trim($row[1])]['id'];
    
    fputcsv($h,$row);
} 

 
  function createCategory($data,$storeId) {
 
      echo "Starting {$data['general']['name']} [{$data['category']['parent']}] ...";
 
      $category = Mage::getModel('catalog/category');
      $category->setStoreId($storeId);
 
      # Fix must be applied to run script
      #http://www.magentocommerce.com/boards/appserv/main.php/viewreply/157328/
      
          if (is_array($data)) {
              $category->addData($data['general']);
 
              if (!$category->getId()) {
 
                  $parentId = $data['category']['parent'];
                  if (!$parentId) {
                      if ($storeId) {
                          $parentId = Mage::app()->getStore($storeId)->getRootCategoryId();
                      }
                      else {
                          $parentId = Mage_Catalog_Model_Category::TREE_ROOT_ID;
                      }
                  }
                  $parentCategory = Mage::getModel('catalog/category')->load($parentId);
                  $category->setPath($parentCategory->getPath());
 
              }
 
                    /**
                     * Check "Use Default Value" checkboxes values
                     */
                    if ($useDefaults = $data['use_default']) {
                        foreach ($useDefaults as $attributeCode) {
                            $category->setData($attributeCode, null);
                        }
                    }              
 
              $category->setAttributeSetId($category->getDefaultAttributeSetId());
 
              if (isset($data['category_products']) &&
                  !$category->getProductsReadonly()) {
                  $products = array();
                  parse_str($data['category_products'], $products);
                  $category->setPostedProducts($products);
              }
 
              try {
                  $category->save();
                  echo "Suceeded with id " . $category->getId() . "\n";
                  return $category->getId();
              }
              catch (Exception $e){
                      echo "Failed <br />";
 
              }
          }      
 
  }

