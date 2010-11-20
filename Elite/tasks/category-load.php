<?php
require_once('../../../../Mage.php');
Mage::app('admin')->setUseSessionInUrl(false);

$csv = new Csv_Reader('ekow-products.csv');


$top_level_categories = array();
$sub1_categories = array();
$sub2_categories = array();
$sub3_categories = array();

$rows = array();
while($row = $csv->getRow())
{
    array_push($rows,$row);
    if(!in_array($row[1],$top_level_categories))
    {
        $top_level_categories[] = $row[1];
        if($row[2] && !in_array($row[2],$sub1_categories))
        {
            $sub1_categories[$row[1]][] = $row[2];
            if($row[3] && !in_array($row[3],$sub2_categories))
            {
                $sub2_categories[$row[1]][$row[2]][] = $row[3];
                if($row[4] && !in_array($row[4],$sub3_categories))
                {
                    $sub3_categories[$row[1]][$row[2]][$row[3]][] = $row[4];
                }
            }
        }
    }
}

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
    
    foreach($sub1_categories[$top_level_category] as $sub1_category)
    {
        $data = $baseData;
        $data['general']['name'] = $sub1_category;
        $data['category']['parent'] = $top_level_id;
        $data['general']['path'] = $top_level_id;
        $storeId = 0;

        $sub1_level_id = createCategory($data,$storeId);
        foreach($sub2_categories[$top_level_category][$sub1_category] as $sub2_category)
        {
            $data = $baseData;
            $data['general']['name'] = $sub2_category;
            $data['category']['parent'] = $sub1_level_id;
            $data['general']['path'] = $sub1_level_id;
            $storeId = 0;

            $sub2_level_id = createCategory($data,$storeId);
            foreach($sub3_categories[$top_level_category][$sub1_category][$sub2_category] as $sub3_category)
            {
                $data = $baseData;
                $data['general']['name'] = $sub3_category;
                $data['category']['parent'] = $sub2_level_id;
                $data['general']['path'] = $sub2_level_id;
                $storeId = 0;

                $sub3_level_id = createCategory($data,$storeId);
                foreach($rows as &$row)
                {
                    if($row[1] == $top_level_category)
                    {
                        $row[1] = $top_level_id;
                        if($row[2] == $sub1_category)
                        {
                            $row[2] = $sub1_level_id;
                            if($row[3] == $sub2_category)
                            {
                                $row[3] = $sub2_level_id;
                            }
                        }
                    }
                }
            }
        }
    }
    
}




 
//    umask(0);
//    Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
//        $count = 0;
// 
//    $file = fopen('categories.csv', 'r');
//    while (($line = fgetcsv($file)) !== FALSE) { $count++;
      //$line is an array of the csv elements
// 
//      if (!empty($line[0]) && !empty($line[1])) { 
// 
//          $data['general']['path'] = $line[0];
//          $data['general']['name'] = $line[1];
//          $data['general']['meta_title'] = "";
//          $data['general']['meta_description'] = "";
//          $data['general']['is_active'] = "";
//          $data['general']['url_key'] = "";
//          $data['general']['display_mode'] = "PRODUCTS";
//          $data['general']['is_anchor'] = 0;
// 
//          $data['category']['parent'] = $line[0]; // 3 top level
//          $storeId = 0;
// 
//          createCategory($data,$storeId);
//          sleep(0.5);
//          unset($data);
//        }
// 
//    }  
// 
 
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

//
//$newCsv = fopen('categories.csv','w');
//foreach($categories as $category)
//{
//    fwrite($newCsv, ',' . $category . "\n" );
//}